<?php

namespace App\Contract;

interface TacheRepositoryInterface {
    public function liste();
    public function store( array $data);
    public function edit( $id);
    public function update(array $data, $id);

 }
