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
*------              ©2005 phpMyBitTorrent Development Team              ------*
*-----------               http://phpmybittorrent.com               -----------*
*------------------------------------------------------------------------------*
*/

if (!defined('IN_PMBT')) die ("You can't access this file directly");

define("_admsavebtn","Salva");
define("_admresetbtn","Azzera");
define("_admsaved","Impostazioni salvate!");

#MENU
define("_admmenu","Menu Amministrativo");
define("_admsettings","Impostazioni");
define("_admbans","Ban");
define("_admfilter","Filtro parole");
define("_admcategories","Categorie");
define("_admoptimizedb","Ottimizza Database");
define("_admirc","Chat IRC");
define("_admwebupdate","Aggiornamenti");
define("_admuser","Gestione utenti");
define("_admmassupload","Upload multiplo");

#HOME ADMIN
define("_admoverview","Riepilogo");
define("_admtotalusers","Totale Utenti Registrati:");
define("_admtotaltorrents","Totale Torrent:");
define("_admtotalshare","Totale dati condivisi:");
define("_admtotalpeers","Totale Peer:");
define("_admtotalspeed","Totale velocit&agrave; di trasferimento:");
define("_admtotalseeders","Totale seeder:");
define("_admtotalleechers","Totale leecher:");
define("_admmostusedclient","Client pi&ugrave; utilizzato:");
#DONATION
define("_admppaypal_email","PayPal E-Mail");
define("_admppaypal_emailexplain","E-Mail Address Used with Paypal");

define("_admpsitecost","Site cost");
define("_admpsitecostexplain","Add Donations Goal For The Site In Dollar Amount");

define("_admpreseaved_donations","Donations Collected");
define("_admpreseaved_donationsexplain","Donations Collected In Dollar Amount");

define("_admpdonatepage","Donation Code From PayPal");
define("_admpdonatepageexplain","If You Have a Code from PayPal For A Donation Button Add It Here");

define("_admpdonation_block","Donation Block");
define("_admpdonation_blockexplain","Select If You Want a Donation Block To be shown");

define("_admpnodonate","No Donate Picture");
define("_admpnodonateexplain","<ul><li><b>EU</b> Display's EU Curancey when No donations have been made<li><b>UK</b> Display's UK Curancey when No donations have been made<li><b>US</b>  Display's US Curancey when No donations have been made</ul>This setting does not affect Donation usage.");
define("_admpnodonateopt1","EU");
define("_admpnodonateopt2","UK");
define("_admpnodonateopt3","US");

#CONFIGURAZIONE
define("_admconfigttl","Configurazione di Bit Torrent");

define("_admpupload_dead","Torrenti di Unscrapeable");
define("_admpupload_deadexplain","Usi questo per tenere conto affinchè i torrenti seminati ONU uploaded all'inseguitore che possono essere rimossi al tempo più tardo.");

define("_admpsitename","Nome del Sito");
define("_admpsitenameexplain","Il nome di questa installazione di phpMyBitTorrent. Verr&agrave; visualizzato come titolo pagina.");

define("_admpsiteurl","URL del sito");
define("_admpsiteurlexplain","Indirizzo URL di questo sito. Richiesto per il funzionamento del Tracker.");

define("_admpcookiedomain","Dominio dei Cookie");
define("_admpcookiedomainexplain","Dominio dei Cookie. Il dominio a cui appartiene questo sito (es. tuosito.com). Necessario per il login degli utenti.");

define("_admpcookiepath","Percorso dei Cookie");
define("_admpcookiepathexplain","Percorso dei Cookie. Cambia questo parametro <b>solo</b> se phpMyBitTorrent &egrave; installato in una sottodirectory sul server.");

define("_admpuse_gzip","Utilizza compressione GZIP");
define("_admpuse_gzipexplain","Questa opzione permette di abilitare o meno la compressione GZIP di PHP sulle pagine e sull'output del tracker. Se attivata, verrà risparmiata banda ma l'uso della CPU del server sarà maggiore. Inoltre si è visto che non è sempre possibile utilizzare questa funzionalità a causa dell'incompatibilità di alcuni server. Verificare che il proprio client di Bit Torrent legga correttamente l'output del tracker.");

define("_admpadmin_email","E-Mail Amministratore");
define("_admpadmin_emailexplain","Indirizzo email da cui risulteranno spedite tutte le comunicazioni agli utenti (registrazione, autorizzazioni, ecc.). Non &egrave; necessario che sia un indirizzo vero, tuttavia &egrave; bene che sia identificativo per questo sito.");

define("_admplanguage","Lingua di default");
define("_admplanguageexplain","Specifica la lingua di default da utilizzare quando l'impostazione lingua non &egrave; impostata su Automatico.");

define("_admptheme","Tema");
define("_admpthemeexplain","Imposta il tema di default per questo sito. Gli utenti registrati possono scavalcare questa opzione dal loro pannello di controllo.");

define("_admpwelcome_message","Messaggio di Benvenuto");
define("_admpwelcome_messageexplain","Se impostato, definisce il messaggio che gli utenti visualizzeranno in cima alla Home Page. Se non impostato, essi vedranno il messaggio di benvenuto predefinito nella loro lingua. L'uso di HTML  &egrave; consentito senza limitazioni.");

define("_admpannounce_text","Messaggio del Tracker");
define("_admpannounce_textexplain","Se impostato, definisce il messaggio che gli utenti visualizzeranno nel loro client BitTorrent all'atto della connessione al Tracker. Utile per avvisi e promozioni.");

define("_admpallow_html","Utilizza HTML Avanzato");
define("_admpallow_htmlexplain","Abilita questa opzione per permettere agli utenti di scrivere descrizioni Torrent in HTML utilizzando la versione di FCKeditor fornita con phpMyBitTorrent.<br /><b>ATTENZIONE</b>: la funzionalit&agrave; &egrave; ancora sperimentale!");

define("_admprewrite_engine","SearchRewrite");
define("_admprewrite_engineexplain","SearchRewrite trasforma i complessi URL di PHP in finte pagine HTML, molto pi&ugrave; gradevoli da digitare sulla barra degli indirizzi del browser. Questo sistema &egrave; particolarmente utile per favorire l'indicizzazione del sito da parte dei motori di ricerca. RICHIEDE il mod_rewrite di Apache o il modulo aggiuntivo ISAPI_Rewrite di IIS.");

define("_admptorrent_prefix","Prefisso Torrent");
define("_admptorrent_prefixexplain","Permette di aggiungere un prefisso al nome file di tutti i Torrent in download su questo tracker. Utile per diffondere nome o indirizzo del tracker.");

define("_admptorrent_per_page","Torrent per pagina");
define("_admptorrent_per_pageexplain","Indica quanti Torrent possono essere visualizzati ogni pagina, sia nel listing che durante le ricerche.");

define("_admponlysearch","Solo Ricerca");
define("_admponlysearchexplain","Disabilita la lista dei Torrent ai non Amministratori. Gli utenti (registrati o no) devono effettuare una ricerca per trovare il Torrent di cui necessitano.");

define("_admpmax_torrent_size","Dimensione massima Torrent");
define("_admpmax_torrent_sizeexplain","Dimensione massima (in byte) per i file .torrent in upload. Al conteggio della dimensione NON contribuiscono i file associati al Torrent!");

define("_admpannounce_interval","Intervallo Announce");
define("_admpannounce_intervalexplain","Valore da comunicare al client per l'intervallo minimo di tempo (in secondi) prima di una nuova richiesta di Announce.");

define("_admpannounce_interval_min","Intervallo Announce Minimo");
define("_admpannounce_interval_minexplain","Intervallo minimo che deve trascorrere tra due richieste Announce. Richieste troppo frequenti saranno rifiutate.");

define("_admpdead_torrent_interval","Durata Torrent Morti");
define("_admpdead_torrent_intervalexplain","Indica quanti secondi &egrave; necessario aspettare prima che un Torrent morto (senza peer connessi) venga nascosto dalla visualizzazione.");

define("_admpminvotes","Voti Minimi");
define("_admpminvotesexplain","Numero minimo di voti prima di visualizzare il rapporto di gradimento del Torrent.");

define("_admptime_tracker_update","Tempo di Aggiornamento Tracker Esterni");
define("_admptime_tracker_updateexplain","Specifica l'intervallo di aggiornamento dei Tracker Esterni in secondi. Richiede Autoscrape abilitato.");

define("_admpbest_limit","Limite Best Torrent");
define("_admpbest_limitexplain","Numero di peer al di sopra del quale il Torrent viene incluso nella Top List.");

define("_admpdown_limit","Limite Torrent Morti");
define("_admpdown_limitexplain","Numero di peer al di sotto del quale il Torrent viene incluso nella lista dei Torrent morti.");

define("_admptorrent_complaints","Lamentele Torrent");
define("_admptorrent_complaintsexplain","Permette agli utenti di giudicare i Torrent in base al loro contenuto nel tentativo di bloccare in breve tempo file illegali, come ad esempio materiale pedopornografico. I Torrent che raggiungono un certo numero di lamentele vengono automaticamente bannati dal sistema e gli Amministratori possono leggere le lamentele pi&ugrave; recenti in Amministrazione.");

define("_admptorrent_global_privacy","Protezione Privacy");
define("_admptorrent_global_privacyexplain","Protezione Privacy permette agli utenti che caricano Torrent di porre limitazioni di download agli altri utenti. Grazie ad un sicuro sistema di autorizzazioni, sar&agrave; il proprietario del Torrent a scegliere chi pu&ograve; scaricare cosa.Questa impostazione impedisce automaticamente il download agli utenti non registrati quando il Torrent &egrave; associato ad un utente. Se questa opzione viene disattivata, il download sar&agrave; consentito a seconda delle impostazioni di download globali.");

define("_admpdisclaimer_check","Disclaimer");
define("_admpdisclaimer_checkexplain","Specifica se l'utente che intende registrarsi deve prima accettare un disclaimer, ossia un regolamento con note legali che ricorda all'utente quali sono le responsabilit&agrave; derivate dalla condivisione dei file.");

define("_admpgfx_check","Test di Turing");
define("_admpgfx_checkexplain","Specifica se utilizzare una speciale protezione grafica su alcune pagine. Il codice di sicurezza garantisce protezione contro i BOT automatici di registrazione e azioni non volute da parte degli utenti.");

define("_admpupload_level","Livello di accesso all'upload");
define("_admpupload_levelexplain","Determina i requisiti di accesso per l'upload di Torrent<ul><li><b>TUTTI</b> permette a tutti gli utenti non registrare di effettuare l'upload di Torrent. Non potranno per&ograve; modificare i Torrent o gestirne le Autorizzazioni<li><b>REGISTRATI</b> richiede la registrazione per l'upload</ul>");
define("_admpupload_levelopt1","Tutti");
define("_admpupload_levelopt2","Registrati");
define("_admpupload_levelopt3","Premium");

define("_admpdownload_level","Livello di accesso al download");
define("_admpdownload_levelexplain","<ul><li><b>TUTTI</b> permette il download indistinto dei Torrent<li><b>REGISTRATI</b> richiede la registrazione<li><b>PREMIUM</b> permette solo agli utenti Premium di scaricare un .torrent dal sito</ul>Questa opzione non influenza l'utilizzo del tracker.");
define("_admpdownload_levelopt1","Tutti");
define("_admpdownload_levelopt2","Registrati");
define("_admpdownload_levelopt3","Premium");

define("_admpannounce_level","Livello di accesso al tracker");
define("_admpannounce_levelexplain","<ul><li><b>TUTTI</b> permette a chiunque di effettuare richieste Announce<li><b>REGISTRATI</b> richiede che l'utente abbia effettuato il login (viene controllato l'IP!)</ul>Questa opzione non influenza il download dei file Torrent dal sito.");
define("_admpannounce_levelopt1","Tutti");
define("_admpannounce_levelopt2","Registrati");

define("_admpmax_num_file","Massimo numero di file per Torrent");
define("_admpmax_num_fileexplain","Limite al numero di file oltre il quale il Torrent non pu&ograve; essere accettato in upload. Un ragionevole modo per incentivare l'uso della compressione dei file. Impostando a zero l'opzione essa verr&agrave; ignorata.");

define("_admpmax_share_size","Dimensione massima Share per Torrent");
define("_admpmax_share_sizeexplain","Limite di share (dimensione dei file associati) oltre il quale il Torrent non viene accettato in upload. L'upload di archivi di non eccessive dimensioni (dividendo una grande collezione, ad esempio) permette agli utenti di scaricare solo i file che interessano e allo stesso tempo, diminuendo i tempi di download per ogni Torrent garantisce un buon rapporto leech/seed. Impostando a zero l'opzione essa verr&agrave; ignorata.");

define("_admpglobal_min_ratio","Ratio Minima Globale");
define("_admpglobal_min_ratioexplain","Questa opzione blocca l'uso del tracker da parte degli utenti con ratio inferiore a quella impostata. L'opzione si applica solo se il Livello di Accesso Announce &egrave; impostato su Utenti Registrati, e non influisce il download dei file Torrent. Impostandola a zero la funzionalit&agrave; viene disattivata.");

define("_admpautoscrape","Autoscrape");
define("_admpautoscrapeexplain","Autoscrape ti permette di aggiornare le statstiche per i Torrent Esterni.<br>USA QUESTA OPZIONE CON CAUTELA!!<br>Puoi usare Autoscrape SOLO se il tuo server &egrave; in grado di aprire socket con qualsiasi client sulla Rete. Molti servizi hosting economici o gratuiti dispongono di firewall che bloccano le connessioni in uscita. Se non usi un Server Dedicato o Casalingo, ti consigliamo di NON abilitare questa opzione a meno che non sei sicuro di ci&ograve; che stai facendo.<br>Se non abiliti Autoscrape tutti i Torrent Esterni verranno visualizzati senza fonti e non potrai farci nulla. Abilitare questa opzione con un server protetto da firewall causer&agrave; un errore di 'Tracker esterno non risponde' al tentativo di upload di Torrent esterni.");

define("_admpmax_num_file_day_e","Massimo numero download giornalieri");
define("_admpmax_num_file_day_eexplain","Definisce quanti download possono essere effettuati da un singolo utente in un'unica giornata. Ulteriori richieste saranno rifiutate e l'utente dovr&agrave; attendere un giorno solare.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpmax_num_file_week_e","Massimo numero download settimanali");
define("_admpmax_num_file_week_eexplain","Definisce quanti download possono essere effettuati da un singolo utente in una settimana. Ulteriori richieste saranno rifiutate e l'utente dovr&agrave; riprovare la settimana successiva.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpmin_num_seed_e","Minimo numero di seed per nuovo download");
define("_admpmin_num_seed_eexplain","Definisce quanti Torrent l'utente deve avere in seed prima di poter scaricare un nuovo file.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpmin_size_seed_e","Minima dimensione seed per nuovo download");
define("_admpmin_size_seed_eexplain","Definisce quanto share l'utente deve avere in seed prima di poter scaricare un nuovo file.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpmaxupload_day_num","Numero massimo di upload giornalieri");
define("_admpmaxupload_day_numexplain","Definisce il massimo numero di Torrent di cui &egrave; possibile fare l'upload in una giornata. Ulteriori upload non verranno accettati e l'utente dovr&agrave; ritentare il giorno successivo.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpmaxupload_day_share","Share massimo in upload giornalmente");
define("_admpmaxupload_day_shareexplain","Definisce la dimensione massima dei Torrent (conteggio dei file associati) di cui &egrave; possibile fare l'upload in una giornata. Ulteriori upload non verranno accettati e l'utente dovr&agrave; ritentare il giorno successivo.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpminupload_file_size","Dimensione minima del Torrent in upload");
define("_admpminupload_file_sizeexplain","Definisce la dimensione minima (conteggio file associati) dei Torrent di cui &egrave; possibile effettuare l'upload.<br>Gli utenti Premium non risentono di questa impostazione. Impostando zero, questa funzionalit&agrave; verr&agrave; disabilitata.");

define("_admpallow_backup_tracker","Tracker di Backup");
define("_admpallow_backup_trackerexplain","Abilita il Tracker di Backup secondo l'estensione Announce-List. Valgono le impostazioni di Announce e non ha effetto sulle ratio. L'opzione viene ignorata se la Modalit&agrave; Stealth &egrave; attiva.");

define("_admpstealthmode","Modalit&agrave; Stealth");
define("_admpstealthmodeexplain","La Modalit&agrave; Stealth disabilita e nasconde il tracker dalla Rete. phpMyBitTorrent accetter&agrave; solo Torrent Esterni.");

#FILTRO PAROLE CHIAVE
define("_admnofilterkey","Non ci sono parole chiave per il filtro");
define("_admaddkeyword","Aggiungi/Modifica parola chiave");
define("_admkeyword","Parola Chiave");
define("_admkeywordreason","Motivo dell'esclusione");
define("_admmissingkeyword","Parola chiave non specificata");
define("_admmissingreason","Motivo non specificato");
define("_admkeywordillegalformat","La parola chiave deve avere da 5 a 50 caratteri alfanumerici");
define("_admreasonillegalformat","Il motivo non deve superare i 255 caratteri");
define("_admfilterintro","Con il filtro a Parola Chiave puoi impedire che un utente inserisca in questo sistema Torrent non conformi al regolamento o alle leggi vigenti.<br />
Fai molta attenzione a non inserire parole troppo generiche che impedirebbero l'upload di Torrent perfettamente in regola.");

#CATEGORIE
define("_admcategoriesintro","In questa sezione puoi gestire le categorie di Torrent che gli utenti possono inviare. L'installazione fornisce alcune categorie comuni per i Torrent.<br />
Puoi aggiungerne delle altre o modificare quelle esistenti. Fai attenzione affinch&egrave; ogni categoria sia rappresentata da una immagine significativa. Le immagini si trovano nella directory <i>cat_pics</i>
a partire dalla directory principale. Qualora il tema in uso possieda una directory <i>pics/cat_pics</i>, le immagini contenute all'interno di questa avranno la precedenza rispetto alle immagini globali.");
define("_admiconintro","In this section you can upload new images to use for you category Icons. at this time you are allowed to use png, gif, jpg , and jpeg. You well need to remember that your <br />
Icon size is 45px X 45px and the file size is set to 17mb. Ones you have added your new icon you can add it to this list from above.");
define("_admnocategories","Non ci sono categorie");
define("_admcatname","Nome");
define("_admcatimage","Immagine");
define("_admaddcategory","Aggiungi/Modifica categoria");
define("_admposition","Posizione");
define("_admatend","Alla fine");
define("_admatbegin","All'inizio");
define("_admafter","Dopo");
define("_admupcat","Upload Category Icon:");
define("_admcattoobig","Category Icon Is To Big");
define("_adminvalidcatfname","Invalid Category Icon ");
define("_admerrnocatupload","Fatal error in uploaded Category Icon.");
define("_admnewcategory","Add New category icon");

#OTTIMIZZAZIONE DATABASE
define("_admtable","Tabella");
define("_admstatus","Stato Ottimizzazione");
define("_admspacesaved","Spazio Risparmiato");
define("_admaoptimized","Gi&agrave; Ottimizzata");
define("_admoptimized","Ottimizzata");

#BAN UTENTI
define("_admban","Ban Utenti");
define("_admbanintro","Usa questa pagina per bannare gli utenti indesiderati dal tracker. Puoi definire interi intervalli di IP da bannare e gestire gli utenti bannati. Puoi anche inserire una motivazione del ban, che sar&agrave; mostrata all'utente bannato.");
define("_admbannedips","IP Bannati");
define("_admbannedusers","Utenti Bannati");
define("_admnobannedips","Non ci sono IP bannati");
define("_admbanipstart","IP Iniziale");
define("_admbanendip","IP Finale");
define("_admbanreason","Motivo");
define("_admbanactions","Azioni");
define("_admnobannedusers","Non ci sono utenti bannati");
define("_admaddeditban","Aggiungi/Modifica un Ban");
define("_admbaniprange","Banna un IP o un intervallo di IP");
define("_admbanuser","Banna un utente");
define("_admbaninvalidip","Gli indirizzi IP DEVONO essere validi indirizzi IPv4 nel formato AAA.BBB.CCC.DDD dove ogni ottetto &egrave; un numero compreso tra 0 e 255.");
define("_admbanusernoexist","L'utente non esiste");

#GESTIONE TRACKER ESTERNI
define("_admtrackers","Tracker Esterni");
define("_admtrackerintro","Con questo Pannello puoi monitorare lo stato dei tracker esterni che sono associati ai Torrent in upload su questo sito.
Puoi impostare un filtro in modo da impedire l'upload di Torrent provenienti da certi tracker o puoi forzare l'aggiornamento del tracker visualizzando
in tempo reale le informazioni di debug.");
define("_admnotrackers","Non ci sono tracker esterni");
define("_admtrackerurl","URL Announce");
define("_admtrkstatus","Stato");
define("_admtrkstatusactive","Attivo");
define("_admtrkstatusdead","Offline");
define("_admtrkstatusblack","Escluso");
define("_admtrklastupdate","Aggiornato");
define("_admtrkscraping","Aggiornamento");
define("_admtrkassociatedtorrents","Torrent");
define("_admtrkviewtorrents","(Vedi)");
define("_admtrkforcescrape","Forza Aggiornamento");
define("_admtrkblacklist","Escludi");
define("_admtrkunblacklist","Non Escludere");
define("_admtrkscraping","Aggiornamento in corso del tracker...");
define("_admtrkcannotopen","Impossibile aprire l'indirizzo URL. Il tracker verr&agrave; impostato come Offline");
define("_admtrkrawdata","Tracker contattato. Di seguito la risposta in formato codificato");
define("_admtrkinvalidbencode","Impossibile decodificare la risposta del tracker. Codifica non valida.");
define("_admtrkdata","Lettura dati completa. Qui di seguito quanto ottenuto dal tracker per lo scrape");
define("_admtrksummarystr","Trovati <b>**seed**</b> seeders, <b>**leechers**</b> leechers, <b>**completed**</b> completi per il Torrent **name** Info Hash **hash**.");
define("_admbannewtracker","Escludi un tracker");
define("_admbannewtrackerintro","Inserisci l'URL Announce di un tracker che intendi escludere. Tutti i Torrent associati ad esso verranno rifiutati.");

#TORRENTCLINIC
define("_admclinicintro","TorrentClinic&trade; ti permette di verificare lo stato di salute dei tuoi Torrent.<br />
Se hai problemi con un Torrent puoi provare a verificare che sia stato creato correttamente, oppure puoi semplicemente curiosare al suo interno.<br />
Facendo l'upload di un Torrent dal disco rigido potrai verificare tutte le informazioni in esso contenute e persino controllare se ha fonti!");
define("_admclinicshowxml","Mostra Strutture XML Avanzate (utili per il debug)");
define("_admclinicforcescrape","Forza lo scrape sui Torrent Esterni");
define("_admclinicdiag","Diagnostica");
define("_admclinicdecoding","Lettura del Torrent in corso...");
define("_admclinicdecodeerror","Errore di Decodifica. Probabilmente il file non è un valido metainfo di BitTorrent.");
define("_admclinicxmlstruct","Struttura XML");
define("_admclinickchkannounce","Controllo del tracker predefinito...");
define("_admclinicchkannounceerror","Il tracker predefinito non &egrave; impostato. Torrent non valido.");
define("_admclinicinvalidannounce","Non valido");
define("_admclinickchkinfo","Controllo dizionario Info...");
define("_admclinicchkinfoerror","Non &egrave; presente il dizionario Info. Torrent non valido.");
define("_admclinicchkinfook","Trovato");
define("_admclinicchkmulti","Controllo numero di file...");
define("_admclinicchkmultis","Il Torrent contiene un solo file");
define("_admclinicchkmultim","Il Torrent contiene pi&ugrave; file");
define("_admclinicchkmultif","Il Torrent non &egrave; consistente!!");
define("_admclinicchkfile","File:");
define("_admchkinvalidfilepath","Percorso del file non valido");
define("_admclinickchktotsize","Dimensione totale:");
define("_admclinicchkplen","Controllo dimensione delle parti...");
define("_admclinicchkplenmissing","Dimensione delle Parti Mancante. Torrent non valido!");
define("_admclinicchkpieces","Controllo delle parti...");
define("_admclinicchkpiecesok","Dati validi!");
define("_admclinicchkpiecesfail","Dati non validi!");
define("_admclinicchkpiecesmissing","Dati mancanti!");
define("_admclinicchkbasic","Questo Torrent risulta valido rispetto alle informazioni di base.");
define("_admclinicchkadvanced","Inizio dei controlli avanzati...");
define("_admclinicdht","Controllo del Supporto DHT in Azureus...");
define("_admclinicannouncelist","Controllo Tracker Multipli...");
define("_admclinicsupported","Supportato");
define("_admclinicnotsupported","Non Supportato");
define("_admclinicscraping","Interrogazione Tracker...");
define("_admclinicscrapefail","Sembra che il Torrent non sia registrato al Tracker Esterno");

#IRC
define("_admircintro","Questo pannello ti permette di configurare la chat IRC integrata di phpMyBitTorrent, che pu&ograve; essere abilitata agli utenti in modo da farli
incontrare in un canale chat predefinito. Puoi configurare il client PJIRC in tutti i suoi aspetti: leggi la documentazione del programma prima di manipolare i parametri avanzati.<br />
<b>NOTA</b>: il file <i>include/irc.ini</i> DEVE essere scrivibile");
define("_admircserver","Server");
define("_admircchannel","Canale");
define("_admircadvsettings","Qui puoi configurare le impostazioni avanzate di PJIRC. Inserisci i parametri nella forma<br />
<i>nome</i> = </i>valore</i><br />
seguendo la documentazione di PJIRC.");
define("_admircedit","Applica le modifiche");
define("_admircenable","Abilita IRC");
define("_admircdisable","Disabilita IRC");
define("_admirccantdelete","Impossibile eliminare il file <i>include/irc.ini</i> perch&egrave; &egrave; protetto da scrittura. Cancellalo manualmente. Ricorda che la Chat IRC &egrave; ancora attiva!");
define("_admircinvalidhost","Nome host o indirizzo IP non valido");
define("_admircinvalidchannel","Nome canale non valido");
define("_admircinvalidadvanced","Sintassi non valida per i parametri avanzati");
define("_admirccantsave","Impossibile salvare il file <i>include/irc.ini</i> perch&egrave; &egrave; protetto da scrittura. Salvalo manualmente con il contenuto di seguito riportato:");

#WEB UPDATE
define("_admupdintro","phpMyBitTorrent tenter&agrave; ora di verificare se &egrave; disponibile una versione aggiornata del software. &Egrave; necessario che il server sia in grado di effettuare connessioni HTTP.");
define("_admupderror","Errore: impossibile connettersi.");
define("_admupdcurver","La versione attuale di phpMyBitTorrent &egrave; la");
define("_admupdlastver","L'ultima versione di phpMyBitTorrent &egrave; la");
define("_admupdupdate","Ti consigliamo di aggiornare phpMyBitTorrent all'ultima versione.");
define("_admupdnoupdate","Non &egrave; necessario aggiornare phpMyBitTorrent.");

#GESTIONE UTENTI
define("_admuserintro","Questo strumento consente di gestire gli utenti registrati modificando il loro profilo, impostando la loro classe e bannandoli.");
define("_admusersearchbtn","Cerca utente");
define("_admuserlastlogin","Visto l'ultima volta");
define("_admuserlastip","Ultimo IP");
define("_admuserviewprofile","Visualizza profilo");
define("_admusereditprofile","Modifica profilo");
define("_admuserdelete","Elimina utente");
define("_admuserban","Banna utente");
define("_admuserunban","Sbanna utente");

#UPLOAD DI MASSA
define("_admmassuploadintro","Con questo strumento &egrave; possibile effettuare l'upload di pi&ugrave; Torrent contemporaneamente.
Questi, a partire dalla directory di phpMyBitTorrent, devono trovarsi nella directory <i>massupload</i>, la quale deve essere possibilmente scrivibile (per cancellare i Torrent doppi e una volta caricati).<br />
<i>Suggerimento</i>: nei sistemi UNIX, qualora si necessiti di usare una directory diversa, &egrave; possibile sostituire la directory <i>massupload</i> con un <i><u>link simbolico</u></i>.");
define("_admmassdirnoexist","La directory di upload multiplo non esiste o non &egrave; leggibile.");
define("_admmassoptions","Opzioni di ricerca:");
define("_admmassmaxtorrents","Massimo numero di Torrent da elaborare (evita errori di memoria o timeout)");
define("_admmassautodel","Cancella automaticamente Torrent duplicati");
define("_admmassscan","Ricerca");
define("_admnomasstorrents","Non ci sono Torrent disponibili.");
define("_admmasspresent","Il Torrent &egrave; gi&agrave; presente");
define("_admmassalreadyprocessed","Il Torrent &egrave; gi&agrave; stato elaborato");
define("_admmasscantdelete","Impossibile eliminare i Torrent duplicati. Per favore sbarazzatene manualmente o controlla i permessi della direcory.");
define("_admmassscrapelater","Rimanda il controllo delle fonti. Questa opzione salta il controllo delle fonti dei tracker esterni al prossimo aggiornamento automatico.<br />Utile per prevenire inconvenienti per grandi quantit&agrave; di Torrent.");
define("_admmassanonupload","Upload anonimo. Se non selezionata, sembrer&agrave; che tu abbia caricato manualmente il Torrent.");
define("_admmassuploaded","Torrent caricato con successo");
define("_admmasscantdeleteuploaded","Impossibile eliminare i Torrent gi&agrave; elaborati (con successo o meno). Per favore sbarazzatene manualmente o controlla i permessi della direcory.");
?>