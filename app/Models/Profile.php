<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $email
 * @property int $email_verified
 * @property string $username
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $series_id
 * @property string|null $expires
 * @property string $role
 * @property string $team
 * @property string $avatar
 * @property string|null $phone
 * @property string|null $account_facebook
 * @property string|null $account_instagram
 * @property string|null $address
 * @property string|null $birthday
 * @property string|null $lastaccess
 * @property int $active
 * @property int $deleted
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Profile extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'users';
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $incrementing = true;
    /**
     * @var string
     */
    protected $keyType = 'int';
    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'avatar',
        'name',
        'surname',
        'username',
        'email',
        'password',
        'role',
        'zona',
        'team',
        'phone',
        'account_instagram',
        'account_facebook',
        'address',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @param $request
     * @return void
     */
    public function updateProfile($request): void
    {
        $request->validate([
            'username' => 'required|min:1|string',
            'name' => 'required|min:1|string',
            'surname' => 'required|min:1|string',
            'email' => 'nullable|string',
            'birthday' => 'nullable|date_format:d/m/Y|before:today',
            'phone' => 'nullable',
            'address' => 'nullable|string'
        ]);
        User::query()
            ->where('id', Auth::id())
            ->update([
                'username' => $request->username,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'address' => $request->address,
                'birthday' => Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d'),
                'phone' => $request->phone
            ]);
    }

    /**
     * @param $request
     * @return void
     */
    public function updateProfileSocial($request): void
    {
        $request->validate([
            'account_facebook' => 'nullable|url',
            'account_instagram' => 'nullable|url'
        ]);
        User::query()
            ->where('id', Auth::id())
            ->update([
                'account_facebook' => $request->account_facebook,
                'account_instagram' => $request->account_instagram,
            ]);
    }

    /**
     * @param $request
     * @return void
     */
    public function modifyPassword($request): void
    {
        $request->validate([
            'old_password' => 'required|min:8|max:50|string',
            'new_password' => 'required|min:8|max:50|string',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8|max:50|string'
        ]);
        User::query()
            ->where('id', Auth::id())->update([
                'password' => Hash::make($request->new_password)
            ]);
    }
}
