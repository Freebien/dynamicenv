<?

require_once __DIR__ . "/Repo.php";
require_once __DIR__. "/User.php";
require_once __DIR__. "/UserRepo.php";

class Secret {
    public int $id;
    public int $user_id;
    public string $name;
    public string $secret;

    public static string $table = "secret";
    public static string $cipher = "aes-256-cbc";
    public static string $hmac_algo = "sha256";

    public function __construct(int $id, int $user_id, string $name, string $secret) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->secret = $secret;
    }

    public static function WithPlaintext(User $user, string $name, string $plaintext): self {
        $ivlen = openssl_cipher_iv_length(static::$cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, static::$cipher, $user->key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac(static::$hmac_algo, $ciphertext_raw, $user->key, $as_binary=true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        echo "cipher: {$ciphertext}";
        $instance = new self(1, $user->id, $name, $ciphertext);
        return $instance;
    }
    
    public function Decrypt(User $user): string|false {
        $c = base64_decode($this->secret);
        $ivlen = openssl_cipher_iv_length(static::$cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, static::$cipher, $user->key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac(static::$hmac_algo, $ciphertext_raw, $user->key, $as_binary=true);
        if (hash_equals($hmac, $calcmac))
        {
            return $original_plaintext;
        }
        return false;
    }

}