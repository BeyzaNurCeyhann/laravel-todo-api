<?php

namespace App\Repositories\Interfaces;

interface TodoRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Başlık veya açıklamaya göre arama
     */
    public function search(string $term);

    /**
     * Sadece durum güncelleme işlemi
     */
    public function updateStatus(int $id, string $status);
    
}
