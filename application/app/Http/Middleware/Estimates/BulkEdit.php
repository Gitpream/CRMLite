<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [edit] precheck processes for estimates
 *
 * @package    CRMLite
 * @author     CRMLite
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Estimates;
use Closure;
use Log;

class BulkEdit {

    /**
     * This 'bulk actions' middleware does the following (for edit level actions)
     *   1. If the request was for a sinle item
     *         - single item actions must have a query string '?id=123'
     *         - this id will be merged into the expected 'ids' request array (just as if it was a bulk request)
     *   2. loop through all the 'ids' that are in the post request
     *
     * HTML for the checkbox is expected to be in this format:
     *   <input type="checkbox" name="ids[{{ $estimate->bill_estimateid }}]"
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        //validate module status
        if (!config('visibility.modules.estimates')) {
            abort(404, __('lang.the_requested_service_not_found'));
            return $next($request);
        }

        //for a single item request - merge into an $ids[x] array and set as if checkox is selected (on)
        if (is_numeric(request('id'))) {
            $ids[request('id')] = 'on';
            request()->merge([
                'ids' => $ids,
            ]);
        }

        //loop through each estimate and check permissions
        if (is_array(request('ids'))) {

            //validate the each item in the list exists
            foreach (request('ids') as $id => $value) {
                if (!$estimate = \App\Models\Estimate::Where('bill_estimateid', $id)->first()) {
                    abort(409, __('lang.one_of_the_selected_items_nolonger_exists'));
                }
            }

            //permission: does user have permission edit estimates
            if (auth()->user()->is_team) {
                if (auth()->user()->role->role_estimates < 2) {
                    abort(403, __('lang.permission_denied_for_this_item') . " - #$id");
                }
            }
            //client - no permissions
            if (auth()->user()->is_client) {
                abort(403);
            }
        } else {
            //no items were passed with this request
            Log::error("no items were sent with this request", ['process' => '[permissions][estimates][change-category]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate id' => $bill_estimateid ?? '']);
            abort(409);
        }

        //all is on - passed
        return $next($request);
    }
    
    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        //vivibility
        config(['visibility.estimate_modal_client_project_fields' => false]);

    }
}
