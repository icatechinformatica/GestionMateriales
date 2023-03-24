<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;

class RequisicionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_requisicion()
    {
        //When user visit the tasks page
        $response = $this->get(route('requisicion.create'));
        // //He should be able to read the task
        $response->assertStatus(200);
    }
}
