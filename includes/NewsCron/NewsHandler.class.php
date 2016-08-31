<?php

class NewsHandler {

    private $rssURL = array("http://forums.noxiousps.com/index.php?/forum/6-staff-updates.xml/", "http://forums.noxiousps.com/index.php?/forum/11-updates.xml", "http://forums.noxiousps.com/index.php?/forum/5-news-announcements.xml");
    private $array = array();

    const FORUMS_IP = "http://google.com";
    const NEWS_TO_DISPLAY = 5;
    const MONTHS = array("Jan" => "01",
        "Feb" => "02",
        "Mar" => "03",
        "Apr" => "04",
        "May" => "05",
        "Jun" => "06",
        "Jul" => "07",
        "Aug" => "08",
        "Sep" => "09",
        "Oct" => "10",
        "Nov" => "11",
        "Dec" => "12");

    /**
     * @return bool
     */
    public function onlineStatus()
    {
        $curl = curl_init(Self::FORUMS_IP);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($curl,CURLOPT_HEADER,true);
        curl_setopt($curl,CURLOPT_NOBODY,true);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response ? true : false;
    }

    /**
     * Puts data from different rss feeds in one array
     */
    public function constructArray()
    {
        $i = 1;
        foreach($this->rssURL as $row) {
            $load = simplexml_load_file($row);
            foreach($load->channel->item as $item) {
                array_push($this->array, array("title" => $item->title, "description" => strip_tags($item->description), "pubDate" => $this->formatDate($item->pubDate), "origDate" => $item->pubDate, "link" => $item->link));
            }
        }
        $this->array = $this->sksort($this->array, "pubDate");
        $this->array = array_slice($this->array, 0, Self::NEWS_TO_DISPLAY);
    }

    /**
     * @return array
     */
    public function displayArray() {
        return $this->array;
    }

    /**
     * @param $date
     * @return string
     */
    public function formatDate($date)
    {
        $parts = explode(" ", $date);
        $day = $parts[1];
        $month = Self::MONTHS[$parts[2]];
        $year = $parts[3];
        $time = explode(":", $parts[4]);
        return  $year.$month.$day.$time[0].$time[1].$time[2];
    }


    /**
     * Credits to serpro@gmail.com
     * @param $array
     * @param string $subkey
     * @param bool $sort_ascending
     * @return array
     */
    public function sksort(&$array, $subkey="id", $sort_ascending=false) {

        if (count($array))
            $temp_array[key($array)] = array_shift($array);

        foreach($array as $key => $val){
            $offset = 0;
            $found = false;
            foreach($temp_array as $tmp_key => $tmp_val)
            {
                if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
                {
                    $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                        array($key => $val),
                        array_slice($temp_array,$offset)
                    );
                    $found = true;
                }
                $offset++;
            }
            if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
        }

        if ($sort_ascending) $array = array_reverse($temp_array);

        else $array = $temp_array;

        return $array;
    }

    /**
     * If forum server is offline, it will insert data
     */
    public function execute()
    {
        if($this->onlineStatus()) {
            $this->constructArray();
            $data = new NewsData();
            $data->updateNews($this->displayArray());
        }
    }
}