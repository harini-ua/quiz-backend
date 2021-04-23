<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IngredientsEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $food_name;
    protected $drink_name;
    protected $food_ingredients;
    protected $drink_ingredients;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($food_name, $drink_name, $food_ingredients, $drink_ingredients)
    {
        $this->food_ingredients = $food_ingredients;
        $this->drink_ingredients = $drink_ingredients;
        $this->food_name = $food_name;
        $this->drink_name = $drink_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ingredients-email', [
            "food_name" => $this->food_name,
            "drink_name" => $this->drink_name,
            "food_missing" => $this->food_ingredients,
            "drink_missing" => $this->drink_ingredients
        ])->subject('Missing ingredients for your event');
    }
}
