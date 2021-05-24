<?php

use function PHPSTORM_META\type;

class Sender
{

    private $name;
    private $avatar;

    public function __construct($name, $avatar)
    {
        $this->name = $name;
        $this->avatar = $avatar;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    function getName()
    {
        return $this->name;
    }

    function getAvatar()
    {
        return $this->avatar;
    }
}

interface ViberMessage
{

    public function getPostDataJson();
}

class Message implements ViberMessage
{

    public static $TYPE_TEXT = "text";
    public static $TYPE_PICTURE = "picture";
    public static $TYPE_VIDEO = "video";
    public static $TYPE_FILE = "file";
    public static $TYPE_CONTACT = "contact";
    public static $TYPE_LOCATION = "location";

    private $receiver;
    private $min_api_version;
    private $sender; //Sender
    private $tracking_data;
    private $type;

    function __construct($TYPE)
    {
        $this->type = $TYPE;
    }

    function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    function getReceiver()
    {
        return $this->receiver;
    }

    function setMinAPIVersion($minApiVersion)
    {
        $this->min_api_version = $minApiVersion;
    }

    function getMinAPIVersion()
    {
        return $this->min_api_version;
    }

    function setSender($name, $avatar)
    {
        $this->sender = new Sender($name, $avatar);
    }

    function getSender()
    {
        return $this->sender;
    }

    function setTrackingData($trackingData)
    {
        $this->tracking_data = $trackingData;
    }

    function getTrackingData()
    {
        return $this->tracking_data;
    }

    function getType()
    {
        return $this->type;
    }


    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType()
        );
        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

class TextMessage extends Message
{


    private $text;

    function setText($text)
    {
        $this->text = $text;
    }

    function getText()
    {
        return $this->text;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "text" => $this->getText()
        );

        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}


class PictureMessage extends TextMessage
{

    //Required
    //The URL must have a resource with a .jpeg, .png or .gif file extension as the last path segment. Example: http://www.example.com/path/image.jpeg
    // Animated GIFs can be sent as URL messages or file messages. Max image size: 1MB on iOS, 3MB on Android.
    private $media;
    //optional. Recommended: 400x400. Max size: 100kb.
    private $thumbnail;

    function setMedia($media)
    {
        $this->media = $media;
    }

    function getMedia()
    {
        return $this->media;
    }

    function setThumbNail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "text" => $this->getText(),
            "media" => $this->getMedia(),
            "thumbnail" => $this->getThumbnail()
        );
        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

class VideoMessage extends Message
{

    //Size of the video in bytes(required)
    private $size;
    //Video duration in seconds; will be displayed to the receiver	optional. (Max 180 seconds)
    private $duration;
    //Required
    //The URL must have a resource with a .jpeg, .png or .gif file extension as the last path segment. Example: http://www.example.com/path/image.jpeg
    // Animated GIFs can be sent as URL messages or file messages. Max image size: 1MB on iOS, 3MB on Android.
    private $media;
    private $thumbnail;

    function setThumbNail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    function getThumbnail()
    {
        return $this->thumbnail;
    }

    function setMedia($media)
    {
        $this->media = $media;
    }

    function getMedia()
    {
        return $this->media;
    }

    function setSize($size)
    {
        $this->size = $size;
    }

    function getSize()
    {
        return $this->size;
    }

    function setDuration($duration)
    {
        $this->duration = $duration;
    }

    function getDuration()
    {
        return $this->duration;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "media" => $this->getMedia(),
            "thumbnail" => $this->getThumbnail(),
            "size" => $this->getSize(),
            "duration" => $this->getDuration()
        );

        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

class FileMessage extends Message
{

    //Size of the video in bytes(required)
    private $size;
    //Required
    //The URL must have a resource with a .jpeg, .png or .gif file extension as the last path segment. Example: http://www.example.com/path/image.jpeg
    // Animated GIFs can be sent as URL messages or file messages. Max image size: 1MB on iOS, 3MB on Android.
    private $media;
    //Required
    //File name should include extension. Max 256 characters (including file extension).
    //Sending a file without extension or with the wrong extension might cause the client to be unable to open the file
    private $filename;

    function setFilename($filename)
    {
        $this->filename = $filename;
    }

    function getFilename()
    {
        return $this->filename;
    }

    function setSize($size)
    {
        $this->size = $size;
    }

    function getSize()
    {
        return $this->size;
    }

    function setMedia($media)
    {
        $this->media = $media;
    }

    function getMedia()
    {
        return $this->media;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "media" => $this->getMedia(),
            "size" => $this->getSize(),
            "file_name" => $this->getFilename()
        );

        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

class Contact
{
    private $name;
    private $phoneNumber;

    public function __construct($name, $phoneNumber)
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }

    function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }
}

class ContactMessage extends Message
{

    private $contact;

    function setContact($name, $phoneNumber)
    {
        $this->contact = new Contact($name, $phoneNumber);
    }

    function getContact()
    {
        return $this->contact;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "contact" => array(
                "name" => $this->getContact()->getName(),
                "phone_number" => $this->getContact()->getPhoneNumber()
            )
        );

        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

class Location
{

    private $lat;
    private $lng;

    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    function setLat($lat)
    {
        $this->lat = $lat;
    }

    function getLat()
    {
        return $this->lat;
    }

    function setLng($lng)
    {
        $this->lng = $lng;
    }

    function getLng()
    {
        return $this->lng;
    }
}

class LocationMessage extends Message
{

    private $location;

    function setLocation($lat, $lng)
    {
        $this->location = new Location(
            $lat,
            $lng
        );
    }

    function getLocation()
    {
        return $this->location;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "location" => array(
                "lat" => $this->getLocation()->getLat(),
                "lon" => $this->getLocation()->getLng()
            )

        );

        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

class URLMessage extends Message
{

    private $media;

    function setMedia($media)
    {
        $this->media = $media;
    }

    function getMedia()
    {
        return $this->media;
    }

    public function getPostDataJson()
    {
        $json = array(

            "receiver" => $this->getReceiver(),
            "min_api_version" => $this->getMinAPIVersion(),
            "sender" => array(
                "name" => $this->getSender()->getName(),
                "avatar" => $this->getSender()->getAvatar(),
            ),
            "tracking_data" => "tracking_data",
            "type" => $this->getType(),
            "media" => $this->getMedia()

        );

        $json = json_encode($json);
        echo ($json);
        return $json;
    }
}

//    class TextMessageBroadcast extends TextMessage{

//         private $broadcast_list;

//         function getBroadcastList(){
//             return $this -> broadcast_list;
//         }

//         function setBroadcastList($broadcast_list){
//             $this -> broadcast_list = $broadcast_list;
//         }

//         public function getPostDataJson(){
//             $json = array (

//                 "receiver" => $this -> getReceiver(),
//                 "min_api_version" => $this -> getMinAPIVersion(),
//                 "sender" => array (
//                     "name" => $this -> getSender() -> getName(),
//                     "avatar" => $this -> getSender() -> getAvatar(),
//                 ),
//                 "broadcast_list" => $this -> getBroadcastList(),
//                 "tracking_data" => "tracking_data",
//                 "type" => $this -> getType(),
//                 "text" => $this -> getText()
//             );

//             $json = json_encode( $json );
//             echo ( $json );
//             return $json;
//         }
//     }

//     class PictureMessageBroadcast extends PictureMessage{

//         private $receivers;

//         function getReceivers(){
//             return $this -> receivers;
//         }

//         function setReceivers($receivers){
//             $this -> receivers = $receivers;
//         }

//         public function getPostDataJson(){

//         }

//     }

//     class VideoMessageBroadcast extends VideoMessage{

//         private $receivers;

//         function getReceivers(){
//             return $this -> receivers;
//         }

//         function setReceivers($receivers){
//             $this -> receivers = $receivers;
//         }

//         public function getPostDataJson(){

//         }
//     }

class ButtonCarrousel
{
    private $columns;
    private $rows;
    private $action_type;
    private $action_body;
    private $image;
    private $text;
    private $text_size;
    private $text_v_align;
    private $text_h_align;

    function setColumns($columns)
    {
        $this->columns = $columns;
    }

    function getColumns()
    {
        return $this->columns;
    }

    function setRows($rows)
    {
        $this->rows = $rows;
    }

    function getRows()
    {
        return $this->rows;
    }

    function setActionType($action_type)
    {
        $this->action_type = $action_type;
    }

    function getActionType()
    {
        return $this->action_type;
    }

    function setActionBody($action_body)
    {
        $this->action_body = $action_body;
    }

    function getActionBody()
    {
        return $this->action_body;
    }

    function setImage($image)
    {
        $this->image = $image;
    }

    function getImage()
    {
        return $this->image;
    }

    function setText($text)
    {
        $this->text = $text;
    }

    function getText()
    {
        return $this->text;
    }

    function setTextSize($text_size)
    {
        $this->text_size = $text_size;
    }

    function getTextSize()
    {
        return $this->text_size;
    }

    function setTextVAlign($text_v_align)
    {
        $this->text_v_align = $text_v_align;
    }

    function getTextVAlign()
    {
        return $this->text_v_align;
    }

    function setTextHAlign($text_h_align)
    {
        $this->text_h_align = $text_h_align;
    }

    function getTextHAlign()
    {
        return $this->text_h_align;
    }
}

class CarousselMessage
{

    private $receiver;
    private $type;
    private $min_api_version;
    private $rich_media;
    private $buttons;

    function setButtons($buttons)
    {
        $this->buttons = $buttons;
    }

    function getButtons()
    {
        return $this->buttons;
    }

    function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    function setRichMedia($rich_media)
    {
        $this->rich_media = $rich_media;
    }

    function getReceiver()
    {
        return $this->receiver;
    }

    function getType()
    {
        return $this->type;
    }

    function getMinApiVersion()
    {
        return $this->min_api_version;
    }

    function getRichMedia()
    {
        return $this->rich_media;
    }
}


function send($message, $TOKEN)
{

    if ($message instanceof ViberMessage) {

        $headers = array(
            'X-Viber-Auth-Token: ' . $TOKEN,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  "https://chatapi.viber.com/pa/send_message");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message->getPostDataJson());
        $result = curl_exec($ch);
        echo $result;
    } else {
        echo (" Wrong message type ");
    }
}
