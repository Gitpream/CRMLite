<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [destroy] process for the templates
 * controller
 * @package    CRMLite
 * @author     CRMLite
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Templates\Projects;
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
            'selector' => '#projects_' . $id,
            'action' => 'slideup-slow-remove',
        );

        //deleted from project page
        if (request('source') == 'page') {
            $jsondata['redirect_url'] = url('/templates/projects');
            request()->session()->flash('success-notification', __('lang.request_has_been_completed'));
            return response()->json($jsondata);
        }

        //close modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

        //notice
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

}