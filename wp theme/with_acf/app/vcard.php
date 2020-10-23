<?php
// Heavily modified from https://www.dropbox.com/s/ital543m8dwasnb/vsource.zip?dl=0
namespace App;

class Vcard {

    /**
     *
     * @var array
     */
    var $vcardInformation;
    
    /**
     *
     * @var string 
     */
    var $vacrdFile;
    
    /**
     *
     * @var string
     */
    var $class;
    
    /**
     *
     * @var date
     */
    var $revision_date;
    
    /**
     *
     * @var string
     */
    var $card;

    /**
     * function vcard
     * Constructor
     * 
     * Array initialization with required information to generate vcard
     * 
     * @return boolean
     */
    function vcard($personPostId = null) {
        $personPostId = get_post_type($personPostId) === 'od_person'
            ? $personPostId
            : null;
        if(!$personPostId){
            die();
        }
        $titles_and_locations = get_field('title_and_location', $personPostId) ?: array();
        $first_office_title = $titles_and_locations[0]['title'];
        $prefered_title = get_field('vcard_title', $personPostId) ?: $first_office_title; 
        $prefered_phone = get_field('vcard_tel', $personPostId) ?: od_person_phone_link($personPostId);
        $first_office_fax = $titles_and_locations[0]['location']->fax; 
        $prefered_fax = get_field('vcard_fax', $personPostId) ?: $first_office_fax;
        
        $this->vcardInformation = array(
            // personal information
            "name_prefix" => null,
            "name_suffix" => null,
            "first_name" => $personPostId ? get_field('first_name', $personPostId) : null, 
            "last_name" => $personPostId ? get_field('last_name', $personPostId) : null,
            "display_name" => get_field('vcard_name', $personPostId) ?: null, 
            "additional_name" => $personPostId ? get_field('generational_name', $personPostId) : null,
            "nickname" => null,
            "email1" => $personPostId ? get_field('email', $personPostId) : null,
            "email2" => null,
            "url" => $personPostId ? get_permalink($personPostId) : null,
            "photo" => $personPostId ? get_the_post_thumbnail_url($personPostId, 'thumbnail'): null,
            // work information
            "company" => "Ogletree Deakins",
            "title" => $personPostId ? $prefered_title : null,
            "role" => null,
            "department" => null,
            "office_tel" => $personPostId ? $prefered_phone : null,
            "office_fax" => $personPostId ? $prefered_fax : null,
            "office_info" => array_map( function($row) {
                $location = $row['location'];
                return array(
                    "work_po_box" => null,
                    "work_extended_address" => join(' ', [
                        get_field('premise', $location->ID),
                        get_field('sub_premise', $location->ID)
                    ]),
                    "work_address" => get_field('thoroughfare', $location->ID),
                    "work_city" => get_field('locality', $location->ID),
                    "work_state" => get_field('administrative_area', $location->ID),
                    "work_postal_code" => get_field('postal_code', $location->ID),
                    "work_country" => get_field('country', $location->ID)['label'],
                );
            }, $titles_and_locations),
            // others
            "vcard_tel_business" => $personPostId ? get_field('vcard_tel_business', $personPostId) : null,
            "vcard_tel_mobile" => $personPostId ? get_field('vcard_tel_mobile', $personPostId) : null,
            "timezone" => null,
            "sort_string" => null,
            "note" => null,
        );
        return true;
    }

    /**
     * function build
     * To initialize the vcard with information
     *  
     * @return void
     */
    function initVcard() {
        $info = $this->vcardInformation;

		if (!$info['sort_string']) { $info['sort_string'] = $info['last_name']; }
		if (!$info['sort_string']) { $info['sort_string'] = $info['company']; }
		if (!$this->revision_date) { $this->revision_date = date('Y-m-d H:i:s'); }
		if (!$info['timezone']) { $info['timezone'] = date("O"); }
		if (!$this->class) { $this->class = "PUBLIC"; }

        // basic information
        $this->card = "BEGIN:VCARD\r\n";
        $this->card .= "VERSION:3.0\r\n";
        $this->card .= "CLASS:" . $this->class . "\r\n";
        $this->card .= "REV:" . $this->revision_date . "\r\n";
        
        if (!$this->class) {
            $this->class = "PUBLIC";
        }
        if (!$info['display_name']) {
            $info['display_name'] = trim($info['first_name'] . " " . $info['last_name']);
        }
        if (!$info['sort_string']) {
            $info['sort_string'] = $info['last_name'];
        }
        if (!$info['sort_string']) {
            $info['sort_string'] = $info['company'];
        }
        if (!$info['timezone']) {
            $info['timezone'] = date("O");
        }
        if (!$this->revision_date) {
            $this->revision_date = date('Y-m-d H:i:s');
        }
        
        $this->card .= "FN;CHARSET=utf-8:" . $info['display_name'] . "\r\n";
        $this->card .= "N;CHARSET=utf-8:" . $info['display_name'] . "\r\n";
        if ($info['nickname']) {
            $this->card .= "NICKNAME;CHARSET=utf-8:" . $info['nickname'] . "\r\n";
        }
        if ($info['title']) {
            $this->card .= "TITLE;CHARSET=utf-8:" . $info['title'] . "\r\n";
        }
        if ($info['company']) {
            $this->card .= "ORG:" . $info['company'];
        }
        if ($info['department']) {
            $this->card .= ";" . $info['department'];
        }
        $this->card .= "\r\n";

        if (count($info['office_info']) > 0) {
            foreach ($info['office_info'] as $office) {
                $this->card .= "ADR;TYPE=work:"
                    . $office['work_po_box'] . ";"
                    . $office['work_extended_address'] . ";"
                    . $office['work_address'] . ";"
                    . $office['work_city'] . ";"
                    . $office['work_state'] . ";"
                    . $office['work_postal_code'] . ";"
                    . $office['work_country'] . "\r\n";
            }
        }
        if ($info['email1']) {
            $this->card .= "EMAIL;TYPE=internet,pref:" . $info['email1'] . "\r\n";
        }
        if ($info['email2']) {
            $this->card .= "EMAIL;TYPE=internet:" . $info['email2'] . "\r\n";
        }
        if ($info['vcard_tel_mobile']) {
            $this->card .= "TEL;TYPE=work,cell:" . $info['vcard_tel_mobile'] . "\r\n";
        }
        
        if ($info['office_tel']) {
            $this->card .= "TEL;TYPE=work,voice:" . $info['office_tel'] . "\r\n";
        }
        if ($info['vcard_tel_business']) {
            $this->card .= "TEL;TYPE=work,voice:" . $info['vcard_tel_business'] . "\r\n";
        }
        
        if ($info['office_fax']) {
            $this->card .= "TEL;TYPE=work,fax:" . $info['office_fax'] . "\r\n";
        }
        if ($info['url']) {
            $this->card .= "URL:" . $info['url'] . "\r\n";
        }
        if ($info['photo']) {
            $this->card .= "PHOTO;TYPE=JPEG;ENCODING=b:" . base64_encode(file_get_contents($info['photo'])) . "\r\n";
            // PHOTO;TYPE=JPEG;VALUE=URI:http://example.com/photo.jpg
        }
        if ($info['role']) {
            $this->card .= "ROLE:" . $info['role'] . "\r\n";
        }
        if ($info['note']) {
            $this->card .= "NOTE:" . $info['note'] . "\r\n";
        }
        $this->card .= "TZ:" . $info['timezone'] . "\r\n";
        $this->card .= "END:VCARD\r\n";
    }

    /*
      download() method streams the vcard to the browser client.
     */

    function download() {
        if (!$this->card) {
            $this->initVcard();
        }
        if (!$this->filename) {
            $this->filename = trim($this->vcardInformation['display_name']);
        }
        $this->filename = str_replace(" ", "_", $this->filename);
        header("Content-type: text/directory");
        header("Content-Disposition: attachment; filename=" . $this->filename . ".vcf");
        header("Pragma: public");
        echo $this->card;
        return true;
    }

    public static function createVcardLink($personPostId, $name) {
        return get_admin_url() . "admin-post.php?action=get_vcard&pid=" . $personPostId . "&name=" . $name;
    }
}

add_action( 'admin_post_nopriv_get_vcard', __NAMESPACE__ . '\\get_vcard' );
add_action( 'admin_post_get_vcard', __NAMESPACE__ . '\\get_vcard' );
function get_vcard() {
    $vc = new \App\Vcard;
    $vc->vcard((int)$_REQUEST['pid']);
    $vc->filename = preg_replace( '/[^a-z0-9]+/', '-', strtolower( $_REQUEST['name'] ) );
    $vc->download();
    die();
}
