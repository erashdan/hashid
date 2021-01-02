<?php

namespace Erashdan\Hashid\Test;

use Erashdan\Hashid\HashedIdValidator;
use Illuminate\Support\Facades\Validator;

class ValidationTest extends TestCase
{
    /** @test * */
    public function it_can_validate_if_hashed_id_exist_on_database_using_model_base()
    {
        $this->registerValidator();

        $rules = [
            'key' => 'hashed_exists:' . TestModel::class
        ];

        $invalid_data = [
            'key' => 'ANY KEY'
        ];

        $valid_data = [
            'key' => 'N5zQE4'
        ];

        $failed_validation = $this->app['validator']->make($invalid_data, $rules);
        $this->assertFalse($failed_validation->passes());

        $success_validation = $this->app['validator']->make($valid_data, $rules);
        $this->assertTrue($success_validation->passes());
    }

    protected function registerValidator()
    {
        Validator::extend('hashed_exists', HashedIdValidator::class . '@validate', trans('The selected :attribute is invalid.'));
    }
}
