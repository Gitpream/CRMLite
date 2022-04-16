<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for templates
 *
 * @package    CRMLite
 * @author     CRMLite
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Reminder;
use Illuminate\Http\Request;

class RemindersRepository{



    /**
     * The leads repository instance.
     */
    protected $reminder;

    /**
     * Inject dependecies
     */
    public function __construct(Reminder $reminder) {
        $this->reminder = $reminder;
    }



}