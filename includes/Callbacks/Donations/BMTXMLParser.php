<?php

class BMTXMLParser
{
    
#################################################################################################################################

    /*
   fwrite ($fp, "Order ID: "                                              . $bmtparser->getElement ('orderid')           . "\n");
   fwrite ($fp, "Order Number: "                                          . $bmtparser->getElement ('ordernumber')       . "\n");

   fwrite ($fp, "Name of company, billing address: "                      . $bmtparser->getElement ('billing.company')   . "\n");
   fwrite ($fp, "Last name of customer, billing address: "                . $bmtparser->getElement ('billing.lastname')  . "\n");
   fwrite ($fp, "First name of customer, billing address: "               . $bmtparser->getElement ('billing.firstname') . "\n");
   fwrite ($fp, "Address of customer, line 1, billing address: "          . $bmtparser->getElement ('billing.address1')  . "\n");
   fwrite ($fp, "Address of customer, line 2, billing address: "          . $bmtparser->getElement ('billing.address2')  . "\n");
   fwrite ($fp, "City of customer, billing address: "                     . $bmtparser->getElement ('billing.city')      . "\n");
   fwrite ($fp, "State of customer, billing address: "                    . $bmtparser->getElement ('billing.state')     . "\n");
   fwrite ($fp, "ZIP code of customer, billing address: "                 . $bmtparser->getElement ('billing.zip')       . "\n");
   fwrite ($fp, "Country of customer, billing address: "                  . $bmtparser->getElement ('billing.country')   . "\n");
   fwrite ($fp, "Phone number of customer, billing address: "             . $bmtparser->getElement ('billing.phone')     . "\n");
   fwrite ($fp, "Alternate phone number of customer, billing address: "   . $bmtparser->getElement ('billing.altphone')  . "\n");
   fwrite ($fp, "Fax number of customer, billing address: "               . $bmtparser->getElement ('billing.fax')       . "\n");
   fwrite ($fp, "Customer e-mail address, billing address: "              . $bmtparser->getElement ('billing.email')     . "\n");
   fwrite ($fp, "Customer alternate e-mail address, billing address: "    . $bmtparser->getElement ('billing.altemail')  . "\n");
   fwrite ($fp, "Customer Value Added Tax number in the European Union: " . $bmtparser->getElement ('billing.vatnumber') . "\n");

   fwrite ($fp, "Name of company, shipping address: "                      . $bmtparser->getElement ('shipping.company')   . "\n");
   fwrite ($fp, "Last name of customer, shipping address: "                . $bmtparser->getElement ('shipping.lastname')  . "\n");
   fwrite ($fp, "First name of customer, shipping address: "               . $bmtparser->getElement ('shipping.firstname') . "\n");
   fwrite ($fp, "Address of customer, line 1, shipping address: "          . $bmtparser->getElement ('shipping.address1')  . "\n");
   fwrite ($fp, "Address of customer, line 2, shipping address: "          . $bmtparser->getElement ('shipping.address2')  . "\n");
   fwrite ($fp, "City of customer, shipping address: "                     . $bmtparser->getElement ('shipping.city')      . "\n");
   fwrite ($fp, "State of customer, shipping address: "                    . $bmtparser->getElement ('shipping.state')     . "\n");
   fwrite ($fp, "ZIP code of customer, shipping address: "                 . $bmtparser->getElement ('shipping.zip')       . "\n");
   fwrite ($fp, "Country of customer, shipping address: "                  . $bmtparser->getElement ('shipping.country')   . "\n");
   fwrite ($fp, "Phone number of customer, shipping address: "             . $bmtparser->getElement ('shipping.phone')     . "\n");
   fwrite ($fp, "Fax number of customer, shipping address: "               . $bmtparser->getElement ('shipping.fax')       . "\n");
   fwrite ($fp, "Customer e-mail address, shipping address: "              . $bmtparser->getElement ('shipping.email')     . "\n");

   fwrite ($fp, "The name on which the product should be registered: "     . $bmtparser->getElement ('registername')       . "\n");

   fwrite ($fp, "Ordinal number of item in order: "                        . $bmtparser->getElement ('itemnumber')         . "\n");

   fwrite ($fp, "Product ID: "        . $bmtparser->getElement ('productid')        . "\n");
   fwrite ($fp, "Product name: "      . $bmtparser->getElement ('productname')      . "\n");
   fwrite ($fp, "Quantity ordered: "  . $bmtparser->getElement ('quantity')         . "\n");
   fwrite ($fp, "Price of product: "  . $bmtparser->getElement ('productprice')     . " " . $bmtparser->getElement ('productcurrency') . "\n");
   fwrite ($fp, "Discount amount: "   . $bmtparser->getElement ('productdiscount')  . " " . $bmtparser->getElement ('productcurrency') . "\n");
   fwrite ($fp, "Vendor royalty: "    . $bmtparser->getElement ('vendorroyalty')    . " " . $bmtparser->getElement ('vendorcurrency')  . "\n");
   fwrite ($fp, "Affiliate royalty: " . $bmtparser->getElement ('affiliateroyalty') . " " . $bmtparser->getElement ('vendorcurrency')  . "\n");
   fwrite ($fp, "BMT's royalty: "     . $bmtparser->getElement ('bmtroyalty')       . " " . $bmtparser->getElement ('vendorcurrency')  . "\n");
   fwrite ($fp, "Vendor currency: "   . $bmtparser->getElement ('vendorcurrency')   . "\n");
   fwrite ($fp, "Product currency: "  . $bmtparser->getElement ('productcurrency')  . "\n");
   fwrite ($fp, "Affiliate id: "      . $bmtparser->getElement ('affiliateid')      . "\n");
   fwrite ($fp, "Discount code: "     . $bmtparser->getElement ('discountcode')     . "\n");
   fwrite ($fp, "Item info: "         . $bmtparser->getElement ('iteminfo')         . "\n");
   fwrite ($fp, "Download password: " . $bmtparser->getElement ('downloadpassword') . "\n");
   fwrite ($fp, "Registration key: "  . $bmtparser->getElement ('keydata')          . "\n");

   fwrite ($fp, "Order date: "        . $bmtparser->getElement ('orderdate')        . "\n");
   fwrite ($fp, "Payment currency: "  . $bmtparser->getElement ('ordercurrency')    . "\n");
   fwrite ($fp, "Order IP address: "  . $bmtparser->getElement ('ipaddress')        . "\n");
   fwrite ($fp, "Referral: "          . $bmtparser->getElement ('referral')         . "\n");
   fwrite ($fp, "Order parameters: "  . $bmtparser->getElement ('orderparameters')  . "\n");
   fwrite ($fp, "Purchase order: "    . $bmtparser->getElement ('ponumber')         . "\n");
   fwrite ($fp, "Customer comments: " . $bmtparser->getElement ('comments')         . "\n");
   fwrite ($fp, "How heard: "         . $bmtparser->getElement ('howheard')         . "\n");
   fwrite ($fp, "Comments (ccom): "   . $bmtparser->getElement ('ccom')             . "\n");

*/
#################################################################################################################################

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