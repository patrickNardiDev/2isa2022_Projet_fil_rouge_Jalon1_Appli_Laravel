<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Message extends Model
{
    use HasFactory;

    protected $table = 'USERS_MESSAGES';

    private static $IdMessage = 50000;

    public function getAllMessagesForTicket(int $IdTicket)
    {
        /**
         * Utilisation de la façade DB::select
         */
        return DB::select("SELECT mt.IdMessage as 'id', t.sujet as 'sujet' ,st.Label as 'status_label', mt.IdTicket as 'id_ticket', um.Content as 'msg', u.id as 'id_user', CONCAT(u.Nom, ' ', LEFT(u.Prenom, 1), '.') AS 'nom', um.CreateAt as 'date_message', t.CreatedAt as 'date_de_creation', t.UpdateAt as 'date_de_maj', ur.IdRole as 'id_role'
        From MESSAGES_TYCKET mt JOIN USERS_MESSAGES um ON mt.IdMessage = um.Id
            JOIN USERS u ON um.IdAuteur = u.Id
            JOIN TICKETS t ON mt.IdTicket = t.Id
            JOIN STATUS_TYPE st ON t.IdStatus = st.Id
            JOIN USERS_ROLE ur ON um.IdAuteur = ur.IdUser
        WHERE mt.IdTicket = ?", [$IdTicket]);
    }

    public function postMysMessage(Request $request)
    {
        self::$IdMessage++; // TODO
        $result = DB::insert("INSERT INTO USERS_MESSAGES (IdAuteur, Content) values(?,?)", [$request->IdUser, $request->message]);
        dd($result);
        return $result;
    }
}
