<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $created_at
 * @property string $created_from
 * @property string $genome_private_key
 * @property string $genome_public_key
 * @property int $id
 * @property ?string $openssl_iv
 * @property ?string $openssl_tag
 * @property string $order_number
 * @property array $post_data
 * @property string $store_id
 * @property string $token
 * @property int $updated_at
 */
class Order extends Model
{
    /**
     * @param string|null $value
     * @return string
     */
    public function getOpensslIvAttribute(?string $value): ?string
    {
        return is_null($value) ? null : base64_decode($value);
    }

    /**
     * @param string|null $value
     */
    public function setOpensslIvAttribute(?string $value): void
    {
        $this->attributes['openssl_iv'] = is_null($value) ? null : base64_encode($value);
    }

    /**
     * @param string|null $value
     * @return string|null
     */
    public function getOpensslTagAttribute(?string $value): ?string
    {
        return is_null($value) ? null : base64_decode($value);
    }

    /**
     * @param string|null $value
     */
    public function setOpensslTagAttribute(?string $value): void
    {
        $this->attributes['openssl_tag'] = is_null($value) ? null : base64_encode($value);
    }

    /**
     * @param string $value
     * @return array
     */
    public function getPostDataAttribute(string $value): array
    {
        return json_decode($value, true);
    }

    /**
     * @param array $value
     */
    public function setPostDataAttribute(array $value): void
    {
        $this->attributes['post_data'] = json_encode($value);
    }
}
