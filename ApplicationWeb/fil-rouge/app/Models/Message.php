<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

// use PHPUnit\Framework\Constraint\IsTrue;

class Message extends Model
{
    use HasFactory;

    // Valeur arbitraire, pour être sup au Id du jeu de données
    // private static int $IdMessage;

    /**
     * Récupère l'ensemble des messages pour un ticket donné
     * 
     * @param int $IdTicket Identifiant du ticket
     * @return array
     */
    public function getAllMessagesForTicket(int $IdTicket)
    {
        /**
         * Utilisation de la façade DB::select
         */
        return DB::select("SELECT mt.IdMessage as 'id',
         t.sujet as 'sujet' ,
         st.Id as 'id_status',
         st.Label as 'status_label',
          mt.IdTicket as 'id_ticket',
          um.Content as 'msg', 
          u.id as 'id_user',
          CONCAT(u.name, ' ', LEFT(u.firstname, 1), '.') AS 'nom', 
          um.CreateAt as 'date_message', 
          t.CreatedAt as 'date_de_creation', 
          t.UpdateAt as 'date_de_maj', 
          ur.IdRole as 'id_role', 
          t.IdTypePanne, pt.Label as 'label_panne'
        From MESSAGES_TYCKET mt JOIN USERS_MESSAGES um ON mt.IdMessage = um.Id
            JOIN users u ON um.IdAuteur = u.id
            JOIN TICKETS t ON mt.IdTicket = t.Id
            JOIN STATUS_TYPE st ON t.IdStatus = st.Id
            JOIN USERS_ROLE ur ON um.IdAuteur = ur.IdUser
            JOIN PANNES_TYPE pt ON t.IdTypePanne = pt.Id
        WHERE mt.IdTicket = ?", [$IdTicket]);
    }

    /**
     * Méthode pour poster un nouveau message via une transacion
     * 
     * @param string $msg le message à poster
     * @param int $newID nouvel identifiant pour le nouveau message
     * 
     * @return bool True si la transaction s'est réalisée sans erreurs; Flase si non
     */
    public function postMyMessage($msg, $newID)
    {
        /**
         * Utilisation de la façade DB::transaction gérant seul les roolback et commit en fonction de la réussite des façade insert
         */
        DB::beginTransaction();
        try {
            // Définit le fuseau horaire par défaut à utiliser.
            date_default_timezone_set('Europe/Paris');
            // définition de la date dans le code et non via la BD pour obtenir les mêmes dans les tables USERS_MESSAGES et TICKETS
            $ToDay = strval(date("Y-m-d H:i:s"));
            $message = strval($msg);
            // l'Id du message est défini par la variable statique est la méthode getNewId
            $rq01 = DB::insert("INSERT INTO USERS_MESSAGES (Id, IdAuteur, Content, CreateAt) values(?,?,?,?)", [$newID, auth()->user()->id, $message, $ToDay]);
            // return true if request ok

            $rq02 = DB::insert("INSERT INTO MESSAGES_TYCKET (IdMessage, IdTicket) values(?,?)", [$newID, session()->get('idTicket')]);
            // return true if request ok

            $rq03 = DB::update("UPDATE TICKETS SET UpdateAt = ? WHERE Id = ?", [$ToDay, session()->get('idTicket')]);
            // return 1 if request ok

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public static function getMaxId()
    {
        return DB::selectone("SELECT MAX(Id) AS 'max' FROM USERS_MESSAGES");
    }
}
