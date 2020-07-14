<?php

namespace App\Domain\Repositories;

interface IProductImageRepository
{
    /**
     * 商品の画像を登録するための関数
     * @param $file_info
     * @return array
     */
    public function imageUpload($file_info): array;
}