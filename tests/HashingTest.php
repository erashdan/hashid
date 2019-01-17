<?php

namespace Erashdan\Hashid\Test;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class HashingTest extends TestCase
{

    /** @test * */
    public function hashid_can_hash_primary_key()
    {
        $this->assertEquals('N5zQE4', $this->testModel->hashed_id);
    }


    /** @test * */
    public function get_correct_element_by_hashed_id()
    {
        $element = TestModel::FindOrFailHashed('N5zQE4');
        $this->assertEquals(1, $element->id);
        $this->assertEquals(2, $element->another_key);
    }

    /** @test * */
    public function throw_exception_if_element_not_exist()
    {
        $this->expectException(ModelNotFoundException::class);
        TestModel::FindOrFailHashed('FAKE_HASH');
    }

    /** @test * */
    public function hashing_id_length_is_changeable()
    {
        config(['hashid.hash_data.length' => 10]);
        $this->assertEquals(
            10,
            strlen($this->testModel->hashed_id)
        );
    }

    /** @test * */
    public function throw_exception_if_hash_key_not_exist()
    {
        config(['hashid.hash_data.key' => null]);
        $this->expectExceptionMessage('Unable to define hashing key');
        $this->assertNotNull($this->testModel->hashed_id);
    }

    /** @test * */
    public function throw_exception_if_hash_length_not_exist()
    {
        config(['hashid.hash_data.length' => null]);
        $this->expectExceptionMessage('Unable to define hashing length');
        $this->assertNotNull($this->testModel->hashed_id);
    }

    /** @test * */
    public function throw_exception_if_hash_length_not_integer()
    {
        config(['hashid.hash_data.length' => 'STRING']);
        $this->expectExceptionMessage('Unable to define hashing length');
        $this->assertNotNull($this->testModel->hashed_id);

    }
}
