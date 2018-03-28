<?php

namespace App\Mail;

use App\Item;
use App\Movement;
use App\Project;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUnload extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Movement
     */
    private $mov;


    /**
     * Create a new message instance.
     *
     * @param Movement $mov
     */
    public function __construct( Movement $mov )
    {

        $this->mov = $mov;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email[ 'user' ] = $this->mov->user->name;
        $email[ 'group' ] = $this->mov->user->group->name;
        $email[ 'depot_name' ] = $this->mov->depotItem->depot->name;
        $email[ 'depot_id' ] = $this->mov->depotItem->depot->id;
        $email[ 'qta' ] = $this->mov->qta;
        $email[ 'item_name' ] = $this->mov->item->name;
        $email[ 'item_code' ] = $this->mov->item->code;
        $email[ 'item_um' ] = $this->mov->item->um;
        $email[ 'project_name' ] = $this->mov->project ?  $this->mov->project->name: null;
        $email[ 'project_id' ] = $this->mov->project ? $this->mov->project->id : null;
        $email[ 'date' ] = $this->mov->created_at->format( "d/m/Y" );
        $email[ 'time' ] = $this->mov->created_at->format( "H:i:s" );


        return $this->markdown( 'emails.notify-unload', compact( 'email' ) )
            ->subject( "[dEPOTS] MOVIMENTO DEPOSITO" );

    }
}
