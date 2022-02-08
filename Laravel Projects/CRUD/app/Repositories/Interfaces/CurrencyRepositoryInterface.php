<?php
namespace App\Repositories\Interfaces;

interface CurrencyRepositoryInterface{
    public function all();
    public function getById(int $id);
    public function paginate(int $id);


}
