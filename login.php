<?php
/* ----------------
 ログイン情報:
 ----------------*/
$integratorKey = "【①インテグレーターキー】";
$email = "【②メールアドレス】";
$password = "【③パスワード】";
$header = "<DocuSignCredentials><Username>" . $email . "</Username><Password>" . $password . "</Password><IntegratorKey>" . $integratorKey . "</IntegratorKey></DocuSignCredentials>";
/* ----------------
 1. ログイン:
 ----------------*/
$url = "https://demo.docusign.net/restapi/v2/login_information"; //認証を行うエンドポイント
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-DocuSign-Authentication: $header"));
$json_response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ( $status != 200 ) {
  echo "error calling webservice, status is:" . $status;
  exit(-1);
}
$response = json_decode($json_response, true);
$accountId = $response["loginAccounts"][0]["accountId"];
$baseUrl = $response["loginAccounts"][0]["baseUrl"]; //この後、実際に署名依頼送信処理等に必要となる値です。
echo "accountId " . $accountId . "\n";
echo "baseUrl " . $baseUrl . "\n";
curl_close($curl);
?>
