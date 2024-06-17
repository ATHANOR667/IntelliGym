<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 0 ;
    public string $state = 'off';

    public function increment ()
    {
       if ($this->state == 'on')
       {
           if ($this->count <10)
           {
               $this->count = $this->count +1 ;
           }
       }
    }

    public function decrement()
    {

       if ($this->state == 'on')
       {
           if ($this->count >0)
           {
               $this->count = $this->count -1 ;
           }
       }

    }
    public function uptadedState($value)
    {
        $this->state = $value;
    }




    public function render()
    {
        return view('livewire.counter',['state'=>$this->state,'count'=>$this->count]);

    }
}
