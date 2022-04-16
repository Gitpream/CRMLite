<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [destroy] process for the comments
 * controller
 * @package    CRMLite
 * @author     CRMLite
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Comments;
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

        //hide and remove row
        $jsondata['dom_visibility'][] = array(
            'selector' => '#comment_' . $comment_id,
            'action' => 'slideup-slow-remove',
        );

        //response
        return response()->json($jsondata);
    }
}
