<?php

class BMTXMLParser
{
    var $tag_name;
    var $tag_attrs;
    var $tag_data;
    var $tag_prev_name;
    var $tag_parent_name;

    function BMTXMLParser()
    {
        $this->tag_name = NULL;
        $this->tag_attrs = NULL;
        $this->tag_data = array();
        $this->tag_prev_name = NULL;
        $this->tag_parent_name = NULL;
    }

    function startElement($parser, $name, $attrs)
    {
        if ($this->tag_name != NULL) {
            $this->tag_parent_name = $this->tag_name;
        }
        $this->tag_name = $name;
        $this->tag_attrs = $attrs;
    }

    function endElement($parser, $name)
    {
        if ($this->tag_name == NULL) {
            $this->tag_parent_name = NULL;
        }
        $this->tag_name = NULL;
        $this->tag_attrs = NULL;
        $this->tag_prev_name = NULL;
    }

    function characterData($parser, $data)
    {
        # Prepend value with attributes, e.g. keypart=1;
        foreach ($this->tag_attrs as $key => $value) {
            $data = $key . "=" . $value . ";" . $data;
        }
        # Separate multiple values with a newline
        if (array_key_exists($this->tag_name, $this->tag_data)) {
            $data = $this->tag_data[$this->tag_name] . "\n" . $data;
        }
        $this->tag_data[$this->tag_name] = $data;
        # Add a second entry for access using parentkey.key notation (needed e.g. for fields like "billing.firstname")
        if ($this->tag_parent_name != NULL) {
            $this->tag_data[$this->tag_parent_name . "." . $this->tag_name] = $data;
        }
        $this->tag_prev_name = $this->tag_name;
    }

    function parse($data)
    {
        $xml_parser = xml_parser_create();
        xml_set_object($xml_parser, $this);
        xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($xml_parser, "startElement", "endElement");
        xml_set_character_data_handler($xml_parser, "characterData");
        $success = xml_parse($xml_parser, $data, true);
        if (!$success) {
            $this->tag_data['error'] = sprintf("XML error: %s at line %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
        }
        xml_parser_free($xml_parser);
        return ($success);
    }

    function getElement($tag)
    {
        return ($this->tag_data[$tag]);
    }
}