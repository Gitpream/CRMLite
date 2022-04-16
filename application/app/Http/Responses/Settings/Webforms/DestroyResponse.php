<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [store] process for the webforms settings
 * controller
 * @package    CRMLite
 * @author     CRMLite
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Webforms;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for webforms
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //remove row
        $jsondata['dom_visibility'][] = array(
            'selector' => "#webform_$id",
            'action' => 'slideup-slow-remove',
        );

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}
