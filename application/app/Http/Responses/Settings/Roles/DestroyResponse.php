<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [destroy] process for the roles settings
 * controller
 * @package    CRMLite
 * @author     CRMLite
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Roles;
use Illuminate\Contracts\Support\Responsable;

class DestroyResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * remove the item from the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //hide and remove all deleted rows
        $jsondata['dom_visibility'][] = array(
            'selector' => '#role_' . $role_id,
            'action' => 'slideup-slow-remove',
        );

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}
