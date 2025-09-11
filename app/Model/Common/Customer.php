<?php

namespace App\Model\Common;

use App\Model\Admin\OrderDetail;
use App\Model\Admin\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public CONST STATUSES = [
        [
            'id' => 1,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
            'id' => 2,
            'name' => 'Khóa',
            'type' => 'danger'
        ]
    ];

    protected $fillable = [
        'fullname', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
        ];
    }

    public function avatar()
    {
        return $this->morphOne(File::class, 'model')->where('custom_field', 'image');
    }

    public function canEdit()
    {

        return true;
    }

    public function canDelete()
    {
        return true;
    }


    public static function getDataForEdit($id) {
        return self::where('id', $id)->firstOrFail();
    }

    public static function searchByFilter($request) {
        $result = self::with([
            'avatar'
        ]);

        if (!empty($request->keywords)) {
            $result = $result->where(function (Builder $query) use ($request) {
                $query->where('fullname', 'like', '%'.$request->keywords.'%')
                    ->orWhere('code', 'like', '%'.$request->keywords.'%');
            });
        }


        if (empty($request->get('order'))) {
            $result = $result->orderBy('created_at', 'DESC');
        }

        return $result;
    }

    public static function searchPostOfCustomer($request) {
        $result = OrderDetail::query()
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->join('posts', 'posts.id', '=', 'order_details.post_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select([
                'orders.code as order_code',
                'posts.name as post_name',
                'orders.created_at as order_created_at',
                'order_details.status',
                'order_details.price',
            ]);

        if (!empty($request->order_code)) {
            $result = $result->where('orders.code', 'like', '%'.$request->order_code.'%');
        }

        if (!empty($request->customer_id)) {
            $result = $result->where('customers.id', $request->customer_id);
        }

        if (!empty($request->post_name)) {
            $result = $result->where('posts.name', 'like', '%'.$request->post_name.'%');
        }

        if (!empty($request->status)) {
            $result = $result->where('order_details.status', $request->status);
        }


        $result = $result->orderBy('orders.created_at', 'DESC');

        return $result;
    }


    public static function getForSelect() {
        return self::select(['id', 'name'])
            ->where('status', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function generateUniqueCode()
    {
        $code = 'KH' . str_pad($this->id, 6, '0', STR_PAD_LEFT);

        return $code;
    }
}
