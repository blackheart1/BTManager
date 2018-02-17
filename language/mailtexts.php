<?php
/*
*-------------------------------phpMyBitTorrent--------------------------------*
*--- The Ultimate BitTorrent Tracker and BMS (Bittorrent Management System) ---*
*--------------   Created By Antonio Anzivino (aka DJ Echelon)   --------------*
*-------------               http://www.p2pmania.it               -------------*
*------------ Based on the Bit Torrent Protocol made by Bram Cohen ------------*
*-------------              http://www.bittorrent.com             -------------*
*------------------------------------------------------------------------------*
*------------------------------------------------------------------------------*
*--   This program is free software; you can redistribute it and/or modify   --*
*--   it under the terms of the GNU General Public License as published by   --*
*--   the Free Software Foundation; either version 2 of the License, or      --*
*--   (at your option) any later version.                                    --*
*--                                                                          --*
*--   This program is distributed in the hope that it will be useful,        --*
*--   but WITHOUT ANY WARRANTY; without even the implied warranty of         --*
*--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          --*
*--   GNU General Public License for more details.                           --*
*--                                                                          --*
*--   You should have received a copy of the GNU General Public License      --*
*--   along with this program; if not, write to the Free Software            --*
*-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA --*
*--                                                                          --*
*------------------------------------------------------------------------------*
*------              2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/
if (!defined('IN_PMBT')) die ("You can't access this file directly");
#User Account Confirmation Email
		$usermailconfirmmailsub = array();
		$userconfirmmailtext = array();
		$usermailconfirmmailsub["italian"] = "Email di Conferm su ".$sitename."";
		$usermailconfirmmailsub["english"] = "Conferm E-mail on ".$sitename."";
		$usermailconfirmmailsub["french"] = "Email de Conferm sur ".$sitename."";
		$usermailconfirmmailsub["brazilian"] = "Conferm E-mail on ".$sitename."";
		$usermailconfirmmailsub["spanish"] = "Email de Conferm en ".$sitename."";
$userconfirmmailtext["english"] = <<<EOF
Hi,
Your email Well be updated on Comfermation of this Notice
Please click on the link below for new email.
$siteurl/user.php?op=confirmemail&user=**uid**&mail_key=**mail_key**
Regards,
**sitename** Staff
**siteurl**
EOF;
$userconfirmmailtext["italian"] = <<<EOF
Hi,
Your email Well be updated on Comfermation of this Notice
Please click on the link below for new email.
$siteurl/user.php?op=confirmemail&user=**uid**&mail_key=**mail_key**
Regards,
**sitename** Staff
**siteurl**
EOF;
$userconfirmmailtext["spanish"] = <<<EOF
Hi,
Your email Well be updated on Comfermation of this Notice
Please click on the link below for new email.
$siteurl/user.php?op=confirmemail&user=**uid**&mail_key=**mail_key**
Regards,
**sitename** Staff
**siteurl**
EOF;
$userconfirmmailtext["french"] = <<<EOF
Hi,
Your email Well be updated on Comfermation of this Notice
Please click on the link below for new email.
$siteurl/user.php?op=confirmemail&user=**uid**&mail_key=**mail_key**
Regards,
**sitename** Staff
**siteurl**
EOF;
$userconfirmmailtext["brazilian"] = <<<EOF
Hi,
Your email Well be updated on Comfermation of this Notice
Please click on the link below for new email.
$siteurl/user.php?op=confirmemail&user=**uid**&mail_key=**mail_key**
Regards,
**sitename** Staff
**siteurl**
EOF;
$userregconfirmmailsub = Array();

$userregconfirmmailsub["italian"] = "Attivazione Account su ".$sitename."";
$userregconfirmmailsub["english"] = "Activate your account on ".$sitename."";
$userregconfirmmailsub["french"] = "Activation d'un compte sur ".$sitename."";
$userregconfirmmailsub["brazilian"] = "Ativa�o da Conta ".$sitename."";
$userregconfirmmailsub["spanish"] = "Activaci� de la Cuenta ".$sitename."";

$userregconfirmmailtext = Array();

$userregconfirmmailtext["italian"] = <<<EOF
Ciao,
tu o qualcun'altro ha richiesto l'iscrizione a **siteurl**. Dobbiamo verificare che l'iscrizione sia stata davvero richiesta da te.\n
Non devi fare altro che fare click (o copia & incolla) sul seguente link di attivazione:
**siteurl**/user.php?op=confirm&username=**username**&act_key=**key**
Una volta confermata l'iscrizione, potrai accedere con i dati che hai inserito in fase di registrazione. Ecco il riepilogo:

------------
Nome utente: **username**
Password: **password**
------------

Ricorda che la password �pesantemente protetta contro gli attacchi. Una volta smarrita, �necessario cambiarla. Per la tua sicurezza ti consigliamo di conservare la password in un luogo molto sicuro.
Ti conviene cancellare questo messaggio se altri utenti condividono il tuo computer.
Adesso �il momento di iniziare a condividere. Grazie per esserti registrato su **siteurl**,
Lo Staff

Se non hai richiesto l'iscrizione al nostro servizio, ti preghiamo di NON fare click sul collegamento e di non inviare alcun messaggio.
Il tuo account non verr�mai attivato e i tuoi dati temporanei verranno presto rimossi dai nostri database.

Saluti,
Lo Staff di **sitename**
**siteurl** 
EOF;

$userregconfirmmailtext["english"] = <<<EOF
Hi,

you have registered an account on **siteurl** . This e-mail is supposed to verify that the registration indeed comes from the owner of this email account.

To activate your account on **siteurl**, please click the following activation link (or copy&paste it to your browser):
**siteurl**/user.php?op=confirm&username=**username**&act_key=**key** 
Once the registration has been confirmed, you will be able to log on to the site with the credentials you provided:

------------
Username: **username**
Password: **password**
------------

Your account is strongly protected against attacks. Keep your password save. In case of loss, you will be required to change it.
You should delete this message if you share your computer with other users.
Time to start sharing. Thanks for joining **siteurl** ,

If you get this message without having requested registration to our services, please DO NOT click the above link.\n
The account will not be activated and your data will soon be removed from our database.

Regards,
**sitename** Staff
**siteurl** 
EOF;

$userregconfirmmailtext["french"] = <<<EOF
Bonjour,
vous ou quelqu'un d'autre s'est enregistr&eacute; par le biais de votre adresse e-mail &agrave; **siteurl***. Il nous faut v&eacute;rifier si cette inscription est r&eacute;ellement la votre.
Il vous suffit de cliquer (ou d'effectuer un copier-coller) sur le lien suivant :
**siteurl**/user.php?op=confirm&username=**username**&act_key=**key**
Une fois l'enregistrement confirm&eacute;, vous pourrez sans restriction acc&eacute;der &agrave; ce site par l'interm&eacute;diaire des nom d'utilisateur et mot de passe choisis. Pour rappel :

------------
Nom d'utilisateur : **username**
Mot de passe : **password**
------------

Gardez en m&eacute;moire que ce mot de passe est fortement prot&eacute;g&eacute; contre tout piratage. Une fois perdu, vous serez oblig&eacute; d'en changer. Pour votre s&eacute;curit&eacute;, gardez-le en un endroit s&ucirc;r.
Nous vous conseillons de supprimer ce message si vous partagez votre ordinateur avec d'autres utilisateurs.
Bienvenue sur **siteurl** et bonne navigation,
Le Boss.

Si vous n'avez jamais demand&eacute; d'inscription &agrave; nos services, merci de NE PAS cliquer sur le lien donn&eacute; et ne pas envoyer de message.\n
Votre compte ne sera jamais activ&eacute; et les donn&eacute;es re&ccedil;ues rapidement effac&eacute;es du syst&egrave;me.

Cordialement,
L'&eacute;quipe **sitename**
**siteurl**
EOF;

$userregconfirmmailtext["brazilian"] = <<<EOF
Ol�
Voc�ou outra pessoa que tenha acesso ao seu email se cadastrou no **siteurl***. Precisamos verificar se o seu cadastramento foi realmente feito por voc�
Por favor, clique (ou copie e cole) o seguinte link de ativa�o:
**siteurl**/user.php?op=confirm&username=**username**&act_key=**key**
Assim que o cadastramento for confirmado, voc�poder�acessar o site com o nome de usu�io e senha que voc�escolheu. Aqui est�um lembrete:

------------
Nome de usu�io: **username**
Senha: **password**
------------

Lembre-se que a sua senha est�protegida contra ataques alheios. Caso ela seja perdida, voc�ter�que mud�la. Para sua seguran�, mantenha-a em um lugar seguro.
Se voc�compartilha este computador com outras pessoas, apague esta mensagem.
Chegou a hora de come�r a compartilhar seus arquivos! Obrigado por entrar na nossa comunidade pelo site **siteurl**.
Atenciosamente,
A equipe.

Caso voc�n� tenha se cadastrado junto aos nossos servi�s, favor N� CLICAR no link acima e nem enviar-nos nenhuma mensagem.
Sua conta nunca ser�ativada e seus dados tempor�ios logo ser� removidos de nossos bancos de dados.

Atenciosamente,
**sitename** Equipe
**siteurl**
EOF;

$userregconfirmmailtext["spanish"] = <<<EOF
Hola!
Ud. o la persona que tambi� tiene acceso a su direcci� de correo electr�ico se ha registrado en el sitio **siteurl***. Tenemos que verificar que Ud. haya sido realmente realizado este registro.
Haga un clic (o copie y pegue) el siguiente enlace de activaci�:
**siteurl**/user.php?op=confirm&username=**username**&act_key=**key**
As�que su registro sea confirmado, Ud. podr�ganar acceso al sitio utilizando el nombre de usuario y contrase� elegidos. Aqu�est�el resumen:

------------
Nombre de usuario: **username**
Contrase�: **password**
------------

Tenga en cuenta que la contrase� est�protegida contra ataques virtuales. Despu� de perdida la contrase�, se le requiere a Ud. que la cambie. Para su propia seguridad, favor de mantenerla en un lugar seguro.
Si lo comparte el ordenador con otros usuarios, le aconsejamos que borre este mensaje despu� de leerlo.
Ahora lleg�el momento de empezar la compartici�. Gracias por registrarse por **siteurl**.
El equipo

Si Ud. no ha requerido el acceso a nuestros servicios, favor de NO HACER UN CLIC en el enlace arriba y ni env�nos un mensaje.
Su cuenta nunca ser�activada y luego sus datos temporarios ser� borrados de nuestra base de datos.

Saludos,
**sitename** Equipo
**siteurl**
EOF;


#New Seeder Notify Email
$seedermailsub = Array();

$seedermailsub["italian"] = "Notifica nuovo seeder su ".$sitename."";
$seedermailsub["english"] = "New seed on ".$sitename."";
$seedermailsub["french"] = "Notification d'une nouvelle source Torrent sur ".$sitename."";
$seedermailsub["brazilian"] = "Aviso de nova semente de Bit Torrent por ".$sitename."";
$seedermailsub["spanish"] = "Aviso de nuevas semillas de Bit Torrent en ".$sitename."";

$seedermailtext = Array();

$seedermailtext["italian"]=<<<EOF
Ciao,
ricevi questo messaggio perch�hai richiesto la notifica di nuove fonti sul Torrent **name** del sito **sitename**.
Un utente ha appena completato il download del Torrent ed �diventato seeder.
Se stavi facendo anche tu da seeder al Torrent, questo potrebbe essere il momento buono per dedicarti a tempo pieno ad un altro Torrent.
Se stavi aspettando che il Torrent avesse un sufficiente numero di fonti, questo �il momento buono per iniziare a scaricarlo!

Non riceverai ulteriori notifiche finch�non visualizzerai la pagina del Torrent:
**torrenturl**

Se invece non vuoi ricevere ulteriori notifiche utilizza il seguente URL:
**unwatchurl**

Saluti,
Lo Staff di **sitename**
**siteurl**
EOF;

$seedermailtext["english"]= <<<EOF
Hello,

you are receiving this message because you requested to be notified when a new seed pops up  for the torrent titled "**name**" on **sitename**.
A user has just finished downloading and is now seeding. If you did a new seed or a reseed, this may be the time to throttle your upload. If you were waiting to start downloading a dead or weak torrent, go for it. Check out the torrent here: **torrenturl**

You will not receive any further notifications for on the torrent until you view that page. You can also turn off notifications for the torrent altogether here: **unwatchurl**

Regards,
**sitename** Staff
**siteurl**
EOF;

$seedermailtext["french"]= <<<EOF
Bonjour,
vous recevez ce message car vous fa&icirc;tes partie des utilisateurs souhaitant recevoir un message
lors de l'apparition d'une nouvelle source pour le Torrent **name** sur le site web **sitename**.
Un utilisateur vient juste de terminer le t&eacute;l&eacute;chargement de ce flux et est devenu seeder.
Si vous &eacute;tiez vous aussi une source du m&ecirc;me Torrent, il peut &ecirc;tre temps de partager un nouveau flux.
Et si vous attendiez apr&egrave;s une telle source, vous pouvez d&egrave;s &agrave; pr&eacute;sent commencer le t&eacute;l&eacute;chargement !

Pour en profiter, visitez la page du Torrent concern&eacute; :
**torrenturl**

Tant que vous n'y serez pas all&eacute;, vous ne recevrez aucune nouvelle alerte pour ce Torrent.
De plus, si vous souhaitez &ecirc;tre radi&eacute; de cette liste de notifications, cliquez sur
l'adresse suivante :
**unwatchurl**

Cordialement,
**sitename** Staff
**siteurl**
EOF;

$seedermailtext["brazilian"]= <<<EOF
Ol�Voc�est�recebendo esta mensagem porque pediu para ser avisado sobre novas sementes para o Torrent **name** no site **sitename**.
Um usu�io acabou de completar o download do Torrent e se tornou uma nova semente.
Se voc�tamb� for uma semente para este Torrent, este seria o momento ideal para coloc�lo �disposi�o.
Se voc�estava esperando por mais sementes deste Torrent, este �o momento ideal para come�r a baix�lo!
Voc�n� receber�outras mensagens de aviso at�que visite a p�ina do Torrent:
**torrenturl**

Se voc�n� quer mais receber avisos sobre este Torrent, use a seguinte URL para desativ�lo:
**unwatchurl**

Atenciosamente,
**sitename** Equipe
**siteurl**
EOF;

$seedermailtext["spanish"]= <<<EOF
Hola!
Est� recibiendo este mensaje porque Ud. ha requerido la notificaci� de nuevas semillas disponibles para el Torrent **name** en el sitio **sitename**.
Un usuario ha acabado de bajar por completo este Torrent y se volvi�en un sembrador.
Si Ud. tambi� es un sembrador del Torrent, esta es su oportunidad de sembrar un nuevo Torrent.
Si Ud. estaba esperando por m� semillas, esta es su oportunidad de empezar a bajar el Torrent!

Ud. no recibir�m� mensajes hasta que visite la p�ina del Torrent en:
**torrenturl**

De otra manera, si no quiere m� recibir mensajes acerca de este Torrent, Ud. podr�utilizar este enlace:
**unwatchurl**

Saludos,
**sitename** Equipo
**siteurl**
EOF;

#Comment Notification Email
$commnotifysub = Array();
$commnotifysub["italian"] = "Nuovo commento su ".$sitename."";
$commnotifysub["english"] = "New comment on ".$sitename."";
$commnotifysub["french"] = "Nouveau commentaire sur ".$sitename."";
$commnotifysub["brazilian"] = "Novo coment�io em ".$sitename."";
$commnotifysub["spanish"] = "Nuevo comentario en ".$sitename."";

$commnotifytext = Array();
$commnotifytext["italian"] = <<<EOF
Ciao,
ricevi questo messaggio perch�hai richiesto di essere informato sui nuovi commenti
per il Torrent **name** pubblicato su **sitename**.
Puoi leggere subito il nuovo commento entrando nella pagina del Torrent su:
**torrenturl**

Fino ad allora non riceverai ulteriori notifiche per questo Torrent.
Se non desideri essere ulteriormente informato sui nuovi commenti a questo Torrent,
visita il seguente url:
**unwatchurl**

Saluti,
Lo Staff di **sitename**
**siteurl**
EOF;

$commnotifytext["english"] = <<<EOF
Hello,
you are receiving this message because you requested to be notified when a new comment was added to the torrent titled
"**name**" on **sitename**.
Read the comment here: **torrenturl**

You will not be notified of any further comments on the torrent until you visit that page. You can also turn off notifications for the torrent altogether here: **unwatchurl**

Regards,
**sitename** Staff
**siteurl**
EOF;

$commnotifytext["french"] = <<<EOF
Bonjour,
vous recevez ce message car vous fa&icirc;tes partie des utilisateurs souhaitant recevoir un message
lors de l'apparition d'un nouveau commentaire concernant le Torrent **name** sur le site web **sitename**.
Un utilisateur vient juste de poster un nouveau message sur le Torrent **name**.
Pour lire celui-ci, merci de cliquer sur le lien suivant :
**torrenturl**

Tant que vous n'y serez pas all&eacute;, vous ne recevrez aucune nouvelle alerte pour ce Torrent.
De plus, si vous souhaitez &ecirc;tre radi&eacute; de cette liste de notifications, cliquez sur
l'adresse suivante :
**unwatchurl**

Cordialement,
**sitename** Staff
**siteurl**
EOF;

$commnotifytext["brazilian"] = <<<EOF
Ol�
Voc�est�recebendo esta mensagem porque pediu para ser avisado sobre o Torrent **name** no site **sitename**.
Um usu�io acabou de publicar um novo coment�io sobre o Torrent **name**.
Para ler esse coment�io, visite: **torrenturl**

At�que voc�visite tal p�ina, voc�n� receber�outros avisos sobre este Torrent.
Se voc�n� quiser mais receber avisos sobre este Torrent, use a seguinte URL para desativ�lo:
**unwatchurl**

Atenciosamente,
**sitename** Equipe
**siteurl**
EOF;

$commnotifytext["spanish"] = <<<EOF
Hola!
Est� recibiendo este mensaje porque Ud. ha requerido la notificaci� de nuevos comentarios acerca del Torrent **name** en el sitio **sitename**.
Un usuario ha acabado de publicar un nuevo comentario acerca del Torrent **name**.
Para leerlo, favor de visitar:
**torrenturl**

Hasta que lea el comentario, Ud. no recibir�otras notificaciones acerca de este Torrent.
De otra manera, si no quiere m� recibir mensajes acerca de este Torrent, Ud. podr�utilizar este enlace:
**unwatchurl**

Saludos,
**sitename** Equipo
**siteurl**
EOF;



#Torrent Privacy notify: subject for ALL emails
$authrespmailsub = Array();
$authrespmailsub["italian"] = "Aggiornamento Autorizzazioni Download per il Torrent **name**";
$authrespmailsub["english"] = "Download Authorization for Torrent **name**";
$authrespmailsub["french"] = "Autorisation de t&eacute;l&eacute;chargement pour le Torrent **name mise &agrave; jour";
$authrespmailsub["brazilian"] = "A autoriza�o de download para o Torrent **name acabou de ser atualizada";
$authrespmailsub["spanish"] = "La autorizaci� para descarga del Torrent **name ha sido actualizada";

#Torrent Privacy notify: GRANT ONCE text
$authgrantmailtext = Array();
$authgrantmailtext["italian"] = <<<EOF
Ciao **slave**,
siamo lieti di comunicarti che l'utente **master** ha approvato la tua richiesta di download per il Torrent **name**.

Puoi scaricarlo direttamente dal seguente link:
**siteurl**/download.php?id=**id**

Ricorda che l'utente pu�in qualunque momento modificare le tue autorizzazioni.
Ti verr�spedita una mail di conferma ad ogni cambiamento delle autorizzazioni di download
per questo e per qualsiasi altro Torrent tu abbia chiesto di scaricare.

Saluti,
Lo Staff
EOF;
$authgrantmailtext["english"] = <<<EOF
**slave**,
we're glad to inform you that user **master** approved your download request for the Torrent **name**.

You can download it here:
**siteurl**/download.php?id=**id**

Remember that the Torrent owner may at any time change your authorizations.
You'll be sent a confirmation message at any authorization change for this and for any other Torrent you requested to download.

Regards,
The Crew
EOF;

$authgrantmailtext["french"] = <<<EOF
Cher **slave**,
nous sommes heureux de vous informer que l'utilisateur **master** a accept&eacute; votre demande de t&eacute;l&eacute;chargement du Torrent **name**.

Vous pouvez d&egrave;s &agrave; pr&eacute;sent le t&eacute;l&eacute;charger en cliquant sur le lien suivant :
**siteurl**/download.php?id=**id**

Souvenez-vous que le propri&eacute;taire de ce Torrent peut &agrave; tout moment modifier vo(s)tre permission(s).
Vous recevrez un message de ce type apr&egrave;s tout changement d'autorisation, et cela pour chaque Torrent que vous d&eacute;sirez t&eacute;l&eacute;charger.

Cordialement,
Le Boss.
EOF;

$authgrantmailtext["brazilian"] = <<<EOF
Caro(a) **slave**,
Gostar�mos de informar-lhe que o usu�io **master** aprovou o seu pedido de download para o Torrent **name**.
Voc�poder�baix�lo no seguinte link:
**siteurl**/download.php?id=**id**

Lembre-se de que o dono do Torrent poder�modificar esta autoriza�o a qualquer momento.
Voc�receber�uma mensagem de confirma�o sobre quaisquer modifica�es que sejam feitas para todos os Torrents relacionados ao seus pedidos de download.

Atenciosamente,
A equipe
EOF;

$authgrantmailtext["spanish"] = <<<EOF
Estimado/a **slave**,
Afortunadamente, nos gustar� informarle que el usuario **master** ha aprobado su pedido de descarga para el Torrent **name**.

Ud. podr�bajarlo por en enlace:
**siteurl**/download.php?id=**id**

Tenga en mente que el due� del Torrent podr� en cualquier instante, revisar sus autorizaciones.
Ud. recibir�un mensaje de confirmaci� siempre que haya cambios en la autorizaci� de acceso a este u otros Torrents que Ud. haya requerido.

Saludos,
El Equipo
EOF;

#Torrent Privacy Notify: DENY ONCE text
$authdenymailtext = Array();
$authdenymailtext["italian"] = <<<EOF
Ciao **slave**,
siamo spiacenti di comunicarti che l'utente **master** ha rifiutato la tua richiesta di download
per il Torrent **name**.

Non potrai scaricare il Torrent fino a quando il proprietario non ti conceder�l'autorizzazione...

Ricorda che l'utente pu�in qualunque momento modificare le tue autorizzazioni.
Ti verr�spedita una mail di conferma ad ogni cambiamento delle autorizzazioni di download per questo e per qualsiasi altro Torrent tu abbia chiesto di scaricare.

Saluti,
Lo Staff
EOF;
$authdenymailtext["english"] = <<<EOF
 **slave**,
we're sorry to inform you that user **master** refused your download request for the Torrent **name**.

You won't be able to download the Torrent until its owner gives you the authorization...

Remember that the Torrent Owner may change your authorizations at any time.
You'll be sent a confirmation message at any authorization change for this and for any Torrent you requested to download.

Regards,
The Crew
EOF;

$authdenymailtext["french"] = <<<EOF
Cher **slave**,
nous sommes d&eacute;sol&eacute;s de vous informer que l'utilisateur **master** a refus&eacute; votre demande de t&eacute;l&eacute;chargement du Torrent **name**.

Vous ne pouvez t&eacute;l&eacute;charger ce Torrent sans autorisation de son propri&eacute;taire...

Souvenez-vous que le propri&eacute;taire de ce Torrent peut &agrave; tout moment modifier vo(s)tre permission(s).
Vous recevrez un message de ce type apr&egrave;s tout changement d'autorisation, et cela pour chaque Torrent que vous d&eacute;sirez t&eacute;l&eacute;charger.

Cordialement,
Le Boss.
EOF;

$authdenymailtext["brazilian"] = <<<EOF
Caro **slave**,
Gostar�mos de informar-lhe que, infelizmente, o usu�io **master** recusou o seu pedido de download para o Torrent **name**.
Voc�n� poder�baix�lo at�que o dono do Torrent lhe d�permiss�...

Lembre-se de que o dono do Torrent poder�modificar esta autoriza�o a qualquer momento.
Voc�receber�uma mensagem de confirma�o sobre quaisquer modifica�es que sejam feitas para todos os Torrents relacionados ao seus pedidos de download.

Atenciosamente,
A equipe
EOF;

$authdenymailtext["spanish"] = <<<EOF
Estimado/a **slave**,
Desafortunadamente, nos gustar� informarle que el usuario **master** ha rechazado su pedido de descarga para el Torrent **name**.

Ud. no podr�descargar este Torrent hasta que su due� le de la autorizaci�...

Tenga en mente que el due� del Torrent podr� en cualquier instante, revisar sus autorizaciones.
Ud. recibir�un mensaje de confirmaci� siempre que haya cambios en la autorizaci� de acceso a este u otros Torrents que Ud. haya requerido.

Saludos,
El Equipo
EOF;

#Torrent Privacy Notification: ALWAYS GRANT text
$authagrantmailtext = Array();
$authagrantmailtext["italian"] = <<<EOF
Ciao **slave**,
siamo lieti di comunicarti che l'utente **master** ha approvato la tua richiesta di download per tutti i Torrent da lui condivisi.

Ogni volta che troverai un Torrent di **master** lo potrai scaricare direttamente!

Ricorda che l'utente pu�in qualunque momento modificare le tue autorizzazioni.
Ti verr�spedita una mail di conferma ad ogni cambiamento delle autorizzazioni di download per questo e per qualsiasi altro Torrent tu abbia chiesto di scaricare.

Saluti,
Lo Staff
EOF;
$authagrantmailtext["english"] = <<<EOF
 **slave**,
we're glad to inform you that user **master** approved your download request for all Torrents he or she is sharing.

You'll be able to directly download any torrent uploaded by **master**.

Remember that the Torrent Owner may change your authorizations at any time .
You'll be sent a confirmation message at the event of any authorization change for this and for any Torrent you requested to download.

Regards,
The Crew
EOF;

$authagrantmailtext["french"] = <<<EOF
Cher **slave**,
nous sommes heureux de vous informer que l'utilisateur **master** a approuv&eacute; votre demande de t&eacute;l&eacute;chargement pour l'ensemble de sa biblioth&egrave;que de Torrents.

D&egrave;s que vous verrez un Torrent appartenant &agrave; **master**, vous pourrez d&eacute;sormais le t&eacute;l&eacute;charger librement !

Souvenez-vous que le propri&eacute;taire de ce Torrent peut &agrave; tout moment modifier vo(s)tre permission(s).
Vous recevrez un message de ce type apr&egrave;s tout changement d'autorisation, et cela pour chaque Torrent que vous d&eacute;sirez t&eacute;l&eacute;charger.

Cordialement,
Le Boss.
EOF;

$authagrantmailtext["brazilian"] = <<<EOF
Caro(a) slave**,
Gostar�mos de informar-lhe que o **master** aprovou o seu pedido de download para todos os Torrents que ele/ela est�compartilhando.

Sempre que voc�encontrar um Torrent que perten� a **master**, voc�poder�baix�lo automaticamente!

Lembre-se de que o dono do Torrent poder�modificar esta autoriza�o a qualquer momento.
Voc�receber�uma mensagem de confirma�o sobre quaisquer modifica�es que sejam feitas para todos os Torrents relacionados ao seus pedidos de download.

Atenciosamente,
A equipe
EOF;

$authagrantmailtext["spanish"] = <<<EOF
Estimado/a **slave**,
Afortunadamente, nos gustar� informarle que el usuario **master** ha aprobado todos sus pedidos de descarga para los Torrents que �/ella est�compartiendo.

Siempre que encuentre un Torrent cuyo/a due�/a sea **master**, Ud. podr�descarg�selo!

Tenga en mente que el due� del Torrent podr� en cualquier instante, revisar sus autorizaciones.
Ud. recibir�un mensaje de confirmaci� siempre que haya cambios en la autorizaci� de acceso a este u otros Torrents que Ud. haya requerido.

Saludos,
El Equipo
EOF;

#Torrent Privacy Notification: ALWAYS DENY text
$authadenymailtext = Array();
$authadenymailtext["italian"] = <<<EOF
Ciao **slave**,
siamo spiacenti di comunicarti che l'utente **master** ha rifiutato la tua richiesta di download per tutti i Torrent da lui condivisi.

Non potrai scaricare alcun Torrent da **master** fino a quando i tuoi permessi non saranno riabilitati...

Ricorda che l'utente pu�in qualunque momento modificare le tue autorizzazioni.
Ti verr�spedita una mail di conferma ad ogni cambiamento delle autorizzazioni di download per questo e per qualsiasi altro Torrent tu abbia chiesto di scaricare.

Saluti,
Lo Staff
EOF;
$authadenymailtext["english"] = <<<EOF
 **slave**,
we're sorry to inform you that user **master** turned down your download request for all the Torrents he or she is sharing.

You won't be able to download any Torrent from **master** until the appropriate permissions are given to you.

Remember that the Torrent Owner may at any time change your authorizations.
You'll be sent a confirmation message at the event of any authorization change for this and for any Torrent you requested to download.

Regards,
The Crew
EOF;

$authadenymailtext["french"] = <<<EOF
Cher **slave**,
nous somme d&eacute;col&eacute; de vous informer que l'utilisateur **master** a refus&eacute; votre demande de t&eacute;l&eacute;chargement pour l'ensemble de sa biblioth&egrave;que de Torrents.

Vous ne pourrez t&eacute;l&eacute;charger aucun Torrent de **master** tant que vos permissions ne seront pas modifi&eacute;es...

Souvenez-vous que le propri&eacute;taire de ce Torrent peut &agrave; tout moment modifier vo(s)tre permission(s).
Vous recevrez un message de ce type apr&egrave;s tout changement d'autorisation, et cela pour chaque Torrent que vous d&eacute;sirez t&eacute;l&eacute;charger.

Cordialement,
Le Boss.
EOF;

$authadenymailtext["brazilian"] = <<<EOF
Caro(a) **slave**,
Lamentamos informar-lhe que o **master** recusou o seu pedido de download para todos os Torrents que ele/ela est�compartilhando.

Voc�n� poder�baixar nenhum Torrent do(a) **master** at�que a permiss� lhe seja dada...

Lembre-se de que o dono do Torrent poder�modificar esta autoriza�o a qualquer momento.
Voc�receber�uma mensagem de confirma�o sobre quaisquer modifica�es que sejam feitas para todos os Torrents relacionados ao seus pedidos de download.

Atenciosamente,
A equipe
EOF;

$authadenymailtext["spanish"] = <<<EOF
Estimado/a **slave**,
Desafortunadamente, nos gustar� informarle que el usuario **master** ha rechazado todos sus pedidos de descarga para los Torrents que �/ella est�compartiendo.

Ud. no podr�descargar ningn Torrent cuyo/a due�/a sea **master** hasta que �/ella le de la autorizaci�...

Tenga en mente que el due� del Torrent podr� en cualquier instante, revisar sus autorizaciones.
Ud. recibir�un mensaje de confirmaci� siempre que haya cambios en la autorizaci� de acceso a este u otros Torrents que Ud. haya requerido.

Saludos,
El Equipo
EOF;

#Torrent Privacy Notification: RESET text
$authresetmailtext = Array();
$authresetmailtext["italian"] = <<<EOF
Ciao **slave**,
ti informiamo che l'utente **master** ha deciso di reimpostare le tue autorizzazioni al download dei Torrent da lui posseduti.

Sono quindi stati ripristinati tutti i vecchi permessi di download prima che ti fossero applicati i permessi globali. Potrai continuare a scaricare i Torrent che potevi scaricare prima, ma non potrai pi scaricare quelli per cui ti era gi�stato negato l'accesso, mentre dovrai fare nuove richieste per i Torrent che non hai mai tentato di scaricare.

Ricorda che l'utente pu�in qualunque momento modificare le tue autorizzazioni.
Ti verr�spedita una mail di conferma ad ogni cambiamento delle autorizzazioni di download per questo e per qualsiasi altro Torrent tu abbia chiesto di scaricare.

Saluti,
Lo Staff
EOF;
$authresetmailtext["english"] = <<<EOF
 **slave**,
we inform you that user **master** has decided to reset all your Torrent download Authorizations for the Torrents he or she owns.

Your old download permissions have now been restored. You will be still able to download the Torrents you were authorized for, but not those for which you weren't authorized. In order to download Torrents you never asked the authorization for, you have to send a new request.

Remember that the Torrent Owner may at any time change your authorizations.
You'll be sent a confirmation message at the event of any authorization change for this and for any Torrent you requested to download.

Regards,
The Crew
EOF;

$authresetmailtext["french"] = <<<EOF
Cher **slave**,
nous vous informons que l'utilisateur **master** a d&eacute;cid&eacute; de r&eacute;actualiser toutes vos autorisations de t&eacute;l&eacute;chargement pour chaque Torrent &eacute;tant en sa possession.

Vos anciennes permissions de t&eacute;l&eacute;chargement ont &eacute;t&eacute; restaur&eacute;es. Il vous reste possible de t&eacute;l&eacute;charger les Torrents pour lesquels vous d&eacute;teniez une autorisation, mais ceux pour lesquels vous n'aviez pas d'autorisation restent toujours inaccessibles.
Pour t�&eacute;charger de tels flux, vous devrez adresser une nouvelle requ&ecirc;te.

Souvenez-vous que le propri&eacute;taire de ce Torrent peut &agrave; tout moment modifier vo(s)tre permission(s).
Vous recevrez un message de ce type apr&egrave;s tout changement d'autorisation, et cela pour chaque Torrent que vous d&eacute;sirez t&eacute;l&eacute;charger.

Cordialement,
Le Boss.
EOF;

$authresetmailtext["brazilian"] = <<<EOF
Caro(a) **slave**,
Gostar�mos de informar-lhe que **master** decidiu zerar todas as suas autoriza�es de download para os Torrents que ele/ela possui.

Suas antigas permiss�s foram restauradas. Voc�continuar�podendo baixar os Torrents para os quais recebeu autoriza�o de download, mas n� ter�acesso �ueles para os quais n� estava autorizado. Para baixar aqueles Torrents para os quais voc�nunca pediu uma autoriza�o, ser�necess�io que voc�envie um pedido para o usu�io.

Lembre-se de que o dono do Torrent poder�modificar esta autoriza�o a qualquer momento.
Voc�receber�uma mensagem de confirma�o sobre quaisquer modifica�es que sejam feitas para todos os Torrents relacionados ao seus pedidos de download.

Atenciosamente,
A equipe
EOF;

$authresetmailtext["spanish"] = <<<EOF
Estimado/a **slave**,
Nos gustar� informarle que el usuario **master** ha decidido restablecer todas las autorizaciones de descarga para los Torrents que �/ella est�compartiendo.

Sus permisiones de descarga antiguas han sido restablecidas. Ud. podr�bajar los Torrents para los cuales tenga autorizaci�, pero no tendr�acceso a los que no tiene autorizaci� de descarga. Para bajar los Torrents que nunca ha requerido, Ud. tendr�que enviarle un nuevo pedido.

Tenga en mente que el due� del Torrent podr� en cualquier instante, revisar sus autorizaciones.
Ud. recibir�un mensaje de confirmaci� siempre que haya cambios en la autorizaci� de acceso a este u otros Torrents que Ud. haya requerido.

Saludos,
El Equipo
EOF;


#Torrent Privacy Notification: REQUEST
$authreqmailsub = Array();
$authreqmailsub["italian"] = "Richiesta di download BIT TORRENT su **sitename**";
$authreqmailsub["english"] = "Download Request on **sitename**";
$authreqmailsub["french"] = "Requ&ecirc;te de t&eacute;l&eacute;chargement BIT TORRENT sur **sitename**";
$authreqmailsub["brazilian"] = "Pedido de download de BIT TORRENT em **sitename**";
$authreqmailsub["spanish"] = "Pedido de descarga BIT TORRENT en **sitename**";

$authreqmailtext = Array();
$authreqmailtext["italian"] = <<<EOF
Ciao **master**,
ricevi questo messaggio perch�l'utente **slave** ha fatto richiesta di scaricare il Torrent **name**.

Non potr�scaricarlo finch�non gli concederai l'autorizzazione dal tuo Pannello Personale:
**siteurl**/mytorrents.php?op=displaytorrent&id=**id**

Ricorda che potrai stabilire se concedergli o meno l'autorizzazione anche valutando il traffico da lui generato.
Potrai permettergli o negarli i download anche per qualsiasi Torrent di cui tu faccia l'upload, e non verrai pi disturbato da queste richieste.

Saluti,
Lo Staff di **sitename**
**siteurl**
EOF;

$authreqmailtext["english"] = <<<EOF
 **master**,
you are receiving this message because the user **slave** requested to download Torrent **name** on **siteurl**.

He won't be able to download it until you give him the authorization from your Personal Panel:
**siteurl**/mytorrents.php?op=displaytorrent&id=**id**

Usually, you'll want to decide what to do considering the user's upload/download ratio.
You're also able to allow or deny him to download ALL the Torrents you will upload in one fell swoop, and you won't be bothered by these requests any more.

Regards,
**sitename** Staff
**siteurl**
EOF;

$authreqmailtext["french"] = <<<EOF
Cher **master**,
vous recevez ce message car l'utilisateur **slave** d&eacute;sirerait t&eacute;l&eacute;charger le Torrent **name**.

Ce Torrent &eacute;tant votre propri&eacute;t&eacute;, vous devrez lui accorder ou non l'autorisation depuis votre panneau personnel :
**siteurl**/mytorrents.php?op=displaytorrent&id=**id**

Nous vous rappellons que vous restez totalement libre de vos actions face au trafic suppl&eacute;mentaire que g&eacute;n&eacute;rera ce nouvel utilisateur.
Il vous est aussi possible de lui laisser la possibilit&eacute; de t&eacute;l&eacute;charger l'int&eacute;gralit&eacute; de votre biblioth&egrave;que de Torrents, auquel cas vous ne serez plus ennuy&eacute; par de telles requ&ecirc;tes.

Cordialement,
L'&eacute;quipe **sitename**
**siteurl**
EOF;

$authreqmailtext["brazilian"] = <<<EOF
Caro **master**,
Voc�est�recebendo esta mensagem porque o usu�io **slave** lhe enviou um pedido para baixar o Torrent **name**.

Ele/Ela n� poder�baix�lo at�que voc�envie uma autoriza�o por meio do seu Painel Pessoal:
**siteurl**/mytorrents.php?op=displaytorrent&id=**id**

Lembre-se que voc�poder�basear sua decis� no tr�ico gerado pelo usu�io.
Voc�poder�enviar-lhe uma permiss� ou recusa para que ele/ela possa baixar todos os Torrents que voc�nos enviou, assim voc�n� receber�mais este tipo de mensagem vinda de tal usu�io.

Atenciosamente,
**sitename** Equipe
**siteurl**
EOF;

$authreqmailtext["spanish"] = <<<EOF
Estimado/a **master**,
Ud. est�recibiendo este mensaje porque el usuario **slave** ha requerido la descarga del Torrent **name**.

�/ella no podr�descarg�selo hasta que Ud. le env� la autorizaci� desde su Panel Personal en:
**siteurl**/mytorrents.php?op=displaytorrent&id=**id**

Tenga en mente que Ud. podr�decidirse acerca de la autorizaci� despu� de consultar las informaciones de tr�ico generado por el usuario.
Ud. podr�permitir o evitar que �/ella pueda bajar todos los Torrents que nos ha enviado y nunca m� ser�importunado por estos pedidos otra vez.

Saludos,
**sitename** Equipo
**siteurl**
EOF;

$lostpasswordemailsub = Array();

$lostpasswordemailsub["italian"] = "Cambio Password su ".$sitename."";
$lostpasswordemailsub["english"] = "Your new Password on ".$sitename."";

$lostpasswordemailtext = Array();
$lostpasswordemailtext["italian"] = <<<EOF
Ciao **user**,

ricevi questo messaggio perch�hai fatto richiesta di cambio password su **sitename**.
La nuova password � **pass**

Per confermare la tua volont�di cambiare la password devi fare click sul seguente link:
**siteurl**/user.php?op=lostpasswordconfirm&user=**userid**&code=**code**

Se non hai fatto richiesta di cambio password, cancella semplicemente questo messaggio.

Saluti,
Lo Staff di **sitename**
**siteurl**
EOF;

$lostpasswordemailtext["english"] = <<<EOF
 **user**,

you are receiving this message because you requested a new password on **sitename**.
Your new password is: **pass**

For the change to become effective, you'll have to confirm it using the following link:
**siteurl**/user.php?op=lostpasswordconfirm&uid=**userid**&code=**code**

If you did not intend to change your password, please disregard this message.

Regards,
**sitename** Staff
**siteurl**
EOF;


$newpmemailsub = Array();
$newpmemailsub["italian"] = "Nuovo messaggio privato su ".$sitename."";
$newpmemailsub["english"] = "New private message on ".$sitename."";

$newpmemailbody = Array();
$newpmemailbody["italian"] = <<<EOF
Ciao **user**,

ricevi questo messaggio perch�l'utente **sender** ti ha inviato un messaggio privato su **sitename**.

Puoi leggerlo all'indirizzo **siteurl**/pm.php?mid=**mid** dopo aver effettuato il login.

Ricorda che se ti ritieni infastidito dal mittente puoi sempre aggiungerlo alla lista degli ignorati.
In questo modo non riceverai pi alcun messaggio da questo utente.

Saluti,
Lo staff di **sitename**
**siteurl**
EOF;
$newpmemailbody["english"] = <<<EOF
**user**,

you are receiving this message because user **sender** has sent you a private message on **sitename**.

You can read the message at **siteurl**/pm.php?mid=**mid** after logging in.

If you feel bothered by the sender, use the blacklist function.
This way you won't receive any more messages from the user.

Regards,
**sitename** Staff
**siteurl**
EOF;
$reseedemailsub = Array();
$reseedemailsub["italian"] = "Nuovo messaggio privato";
$reseedemailsub["english"] = "Requist for Reseed ".$sitename."";

$reseedemailbody = Array();
$reseedemailbody["italian"] = <<<EOF
Ciao **name**,
you are receiving this message because user **sender** sent you a requist for reseed on a torrent ((**torname**)) on **sitename**.

You can read it at **siteurl**/pm.php?mid=**mid2** 
or go here **torrent** for more info on **torname** after you logged in

Saluti,
Lo staff di **sitename**
**siteurl**
EOF;
$reseedemailbody["english"] = <<<EOF
Dear **name**,
you are receiving this message because user **sender** sent you a requist for reseed on a torrent ((**torname**)) on **sitename**.

You can read it at **siteurl**/pm.php?mid=**mid2** 
or go here **torrent** for more info on **torname** after you logged in



Regards,
**sitename** Staff
**siteurl**
EOF;
?>