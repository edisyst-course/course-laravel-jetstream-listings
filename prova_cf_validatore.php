<?php

$nome_data_base = "comuni";

$vocali = array("A", "E", "I", "O", "U");
$cf_alfabeto_mesi = array('A', 'B', 'C', 'D', 'E', 'H', 'L', 'M', 'P', 'R', 'S', 'T');

$cf_alfabeto = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
    'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

// Caratteri in posizione dispari
$PD['0'] = 1;
$PD['B'] = 0;
$PD['M'] = 18;
$PD['X'] = 25;
$PD['1'] = 0;
$PD['C'] = 5;
$PD['N'] = 20;
$PD['Y'] = 24;
$PD['2'] = 5;
$PD['D'] = 7;
$PD['O'] = 11;
$PD['Z'] = 23;
$PD['3'] = 7;
$PD['E'] = 9;
$PD['P'] = 3;
$PD['4'] = 9;
$PD['F'] = 13;
$PD['Q'] = 6;
$PD['5'] = 13;
$PD['G'] = 15;
$PD['R'] = 8;
$PD['6'] = 15;
$PD['H'] = 17;
$PD['S'] = 12;
$PD['7'] = 17;
$PD['I'] = 19;
$PD['T'] = 14;
$PD['8'] = 19;
$PD['J'] = 21;
$PD['U'] = 16;
$PD['9'] = 21;
$PD['K'] = 2;
$PD['V'] = 10;
$PD['A'] = 1;
$PD['L'] = 4;
$PD['W'] = 22;

// Elenco Mesi
$mese[0] = "Gennaio";
$mese[1] = "Febbraio";
$mese[2] = "Marzo";
$mese[3] = "Aprile";
$mese[4] = "Maggio";
$mese[5] = "Giugno";
$mese[6] = "Luglio";
$mese[7] = "Agosto";
$mese[8] = "Settembre";
$mese[9] = "Ottobre";
$mese[10] = "Novembre";
$mese[11] = "Dicembre";

$cf_sesso[0] = "Maschile";
$cf_sesso[1] = "Femminile";

$connessione = mysqli_connect("localhost", "root", "", "$nome_data_base")
or die("Error " . mysqli_error($connessione));
if (!$connessione)
    echo "Connessione fallita!";

$query = "SELECT `comune` FROM `comuni` ORDER BY `comune`";
$result = mysqli_query($connessione, $query);

?>

    <head>
        <title></title>
    </head>

    <body>
Informazioni personali (dati sensibili): <p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <table>
        <tr>
            <td>Cognome:</td>
            <td><input name="cognome"></td>
        </tr>
        <tr>
            <td>Nome:</td>
            <td><input name="nome"></td>
        </tr>
        <tr>
            <td>Data di nascita</td>
            <td>
                <select name="cf_giorno">
                    <option> – Giorno –</option>
                    <?php for ($i = 1; $i <= 31; $i++) echo "<option value='$i'>$i</option>"; ?>
                </select>
                <select name="cf_mese">
                    <option> – Mese –</option>
                    <?php foreach ($mese as $m) echo "<option value='$m'>$m</option>" ?>
                </select>
                <select name="cf_anno">
                    <option> – Anno –</option>
                    <?php for ($i = 1900; $i <= 2013; $i++) echo "<option value='$i'>$i</option>"; ?>
                </select></td>
        <tr>
            <td>Sesso:</td>
            <td><select name="sesso">
                    <?php foreach ($cf_sesso as $g) echo "<option value='$g'>$g</option>" ?>
                </select>
            </td>
        <tr>
            <td>Comune di nascita:</td>
            <td><select name="comune">
                    <?php
                    while ($row = mysqli_fetch_row($result)) {
                        echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                    }
                    mysqli_free_result($result);
                    ?>
                </select></td>
        </tr>
        <tr>
            <td><input type="submit"><input type="reset"></td>
        </tr>
    </table>
</form>


<?php

if ($_POST) {

    $cognome = $_POST['cognome'];
    $nome = $_POST['nome'];
    $cf_g = $_POST['cf_giorno'];
    $cf_m = $_POST['cf_mese'];
    $cf_a = $_POST['cf_anno'];
    $cf_sesso = $_POST['sesso'];
    $cf_comune = $_POST['comune'];
// Codice Fiscale: è formato da 7 elementi
    $cf_elemento[0] = "";
    $cf_elemento[1] = "";
    $cf_elemento[2] = "";
    $cf_elemento[3] = "";
    $cf_elemento[4] = "";
    $cf_elemento[5] = "";
    $cf_elemento[6] = "";

// CODICE PER IL COGNOME (CONSONANTI N°1-2-3 + EVENTUALI VOCALI)
    $cognome = strtoupper($cognome);
    $num_vocali = preg_match_all('/[AEIOU]/i', $cognome, $matches1);
    $num_consonanti = preg_match_all('/[BCDFGHJKLMNPQRSTVWZXYZ]/i', $cognome, $matches2);
    if ($num_consonanti >= 3) $cf_elemento[0] = $matches2[0][0] . $matches2[0][1] . $matches2[0][2];
    else {

        for ($i = 0; $i < $num_consonanti; $i++) {
            $cf_elemento[0] = $cf_elemento[0] . $matches2[0][$i];
        }
        $n = 3 - strlen($cf_elemento[0]);
        for ($i = 0; $i < $n; $i++) {
            $cf_elemento[0] = $cf_elemento[0] . $matches1[0][$i];
        }
        $n = 3 - strlen($cf_elemento[0]);
        for ($i = 0; $i < $n; $i++) $cf_elemento[0] = $cf_elemento[0] . "X";
    }

// CODICE PER IL NOME (CONSONANTI N°1-3-4, OPPURE 1-2-3 SE SONO 3; SE SONO MENO DI 3: VOCALI)
    $nome = strtoupper($nome);
    $num_vocali = preg_match_all('/[AEIOU]/i', $nome, $matches1);
    $num_consonanti = preg_match_all('/[BCDFGHJKLMNPQRSTVWZXYZ]/i', $nome, $matches2);
    if ($num_consonanti >= 4) $cf_elemento[1] = $matches2[0][0] . $matches2[0][2] . $matches2[0][3];
    else if ($num_consonanti == 3) $cf_elemento[1] = $matches2[0][0] . $matches2[0][1] . $matches2[0][2];
    else {
        for ($i = 0; $i < $num_consonanti; $i++) {
            $cf_elemento[1] = $cf_elemento[1] . $matches2[0][$i];
        }
        $n = 3 - strlen($cf_elemento[1]);
        for ($i = 0; $i < $n; $i++) {
            $cf_elemento[1] = $cf_elemento[1] . $matches1[0][$i];
        }
        $n = 3 - strlen($cf_elemento[1]);
        for ($i = 0; $i < $n; $i++) $cf_elemento[1] = $cf_elemento[1] . "X";
    }

// CODIFICA ANNO (Ultime 2 cifre dell'anno)
    $arrAnno = str_split($cf_a);
    $cf_elemento[2] = $arrAnno[2] . $arrAnno[3];

// CODIFICA MESE (A = Gennaio, B = Febbraio, ecc.)
    $m = array_search($cf_m, $mese);
    $cf_elemento[3] = $cf_alfabeto_mesi[$m];

// CODIFICA GIORNO (se uomo; n. giorno (DD); altrimenti n. giorno + 40)
    if ($cf_sesso == "Maschile") $cf_elemento[4] = $cf_g;
    else $cf_elemento[4] = $cf_g + 40;
    if (strlen($cf_elemento[4]) == 1) $cf_elemento[4] = "0" . $cf_elemento[4];

// CODIFICA COMUNE
    $query = "SELECT codice FROM comuni WHERE comune = \"$cf_comune\"";
    $result = mysqli_query($connessione, $query);
    while ($row = mysqli_fetch_row($result)) {
        $cf_elemento[5] = $row[0];
    }
    mysqli_free_result($result);

// CODIFICA CARATTERE DI CONTROLLO ( Per il calcolo: caratteri posiz pari + posiz dispari) / 26 )
    $arrCOD = $cf_elemento[0] . $cf_elemento[1] . $cf_elemento[2] . $cf_elemento[3] . $cf_elemento[4] . $cf_elemento[5];
    $arrCOD = str_split($arrCOD);
    $index = count($arrCOD);
    /* posto pari */
    $somma1 = 0;
    for ($i = 0; $i < 15; $i++)
        if (($i + 1) % 2 == 0) {
            if (!in_array($arrCOD[$i], $cf_alfabeto)) $somma1 += $arrCOD[$i];
            else {
                $n = array_search($arrCOD[$i], $cf_alfabeto);
                $somma1 += $n;
            }
        }
    /* posto dispari */
    $somma2 = 0;
    for ($i = 0; $i < 15; $i++)
        if (($i + 1) % 2 != 0) {
            $somma2 += $PD["$arrCOD[$i]"];
        }
    $somma = $somma1 + $somma2;
    $cf_elemento[6] = ($somma % 26);
    $cf_elemento[6] = $cf_alfabeto[$cf_elemento[6]];
// OUTPUT
    echo "Codice fiscale: $cf_elemento[0] $cf_elemento[1] $cf_elemento[2] $cf_elemento[3] $cf_elemento[4] $cf_elemento[5]
$cf_elemento[6]";

    mysqli_close($connessione);

    ?>
