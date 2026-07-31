<?php

// Mint a Google OAuth2 access token from the Firebase service account
// and store it where the merge script expects it.
$credPath = __DIR__ . '/firebase_credentials.json';
$outPath = '/tmp/opencode/fb_token.txt';

if (!is_file($credPath)) {
    echo "ERROR: credentials not found at $credPath\n";
    exit(1);
}

$cred = json_decode(file_get_contents($credPath), true);
if (!$cred || empty($cred['client_email']) || empty($cred['private_key'])) {
    echo "ERROR: invalid credentials file\n";
    exit(1);
}

$now = time();
$header = base64url(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
$claims = base64url(json_encode([
    'iss' => $cred['client_email'],
    'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/firebase.database',
    'aud' => 'https://oauth2.googleapis.com/token',
    'iat' => $now,
    'exp' => $now + 3600,
]));
$signingInput = "$header.$claims";
$signature = '';
openssl_sign($signingInput, $signature, $cred['private_key'], OPENSSL_ALGO_SHA256);
$jwt = "$signingInput." . base64url($signature);

$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion' => $jwt,
]));
$res = curl_exec($ch);
curl_close($ch);

$data = json_decode($res, true);
if (empty($data['access_token'])) {
    echo "ERROR: could not get token\n$res\n";
    exit(1);
}

@mkdir(dirname($outPath), 0777, true);
file_put_contents($outPath, $data['access_token']);
echo "Token saved to $outPath (expires " . date('c', $now + (int)($data['expires_in'] ?? 3600)) . ")\n";

function base64url($s) {
    return rtrim(strtr(base64_encode($s), '+/', '-_'), '=');
}
