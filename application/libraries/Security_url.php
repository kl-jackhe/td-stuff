<?php defined('BASEPATH') or exit('No direct script access allowed');
class Security_url
{
    private $ci;
    private $url_key; // 隨機密鑰
    private $fixed_key = "%;2Qnp)&XuNv'P[R}&0`Bf8E9X1Vqff,"; // 固定密鑰

    public function __construct($params = array())
    {
        $this->ci = &get_instance();
        $this->ci->load->library('session');
        // 檢查是否存在有效的 URL 鍵
        if ($this->ci->session->has_userdata('url_key')) {
            // 取得會話中的 URL 鍵和過期時間
            $this->url_key = $this->ci->session->userdata('url_key');
        } else {
            // 生成新的 URL 鍵並存儲到會話中
            $this->generateNewURLKey();
        }
    }

    // 生成新的 URL 鍵並存儲到會話中
    private function generateNewURLKey()
    {
        $this->url_key = $this->generateRandomString(); // 生成隨機的 URL 鍵
        $this->ci->session->set_userdata('url_key', $this->url_key);
    }

    // 生成隨機字符串
    private function generateRandomString($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }

    // 生成 JWT
    function generateJWT($payload, $key)
    {
        // 將 Header 與 Payload 轉換為 Base64 字串
        $header = base64_encode(json_encode(array('typ' => 'JWT', 'alg' => 'HS256')));
        $payload = base64_encode(json_encode($payload));

        // 生成 Signature
        $signature = hash_hmac('sha256', "$header.$payload", $key, true);
        $signature = base64_encode($signature);

        // 組合 Header、Payload 與 Signature 以生成 JWT
        $jwt = "$header.$payload.$signature";

        return $jwt;
    }

    // 解析 JWT
    function parseJWT($jwt, $key)
    {
        if (empty($jwt)) {
            return false;
        }

        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return false;
        }

        try {
            list($header, $payload, $signature) = explode('.', $jwt);
            // 驗證 Signature
            $expected_signature = hash_hmac('sha256', "$header.$payload", $key, true);
            $expected_signature = base64_encode($expected_signature);

            if ($signature !== $expected_signature) {
                throw new Exception('Invalid signature');
            }

            // 解碼 Payload
            $payload = json_decode(base64_decode($payload), true);

            // 檢查過期時間
            if (isset($payload['exp']) && time() > $payload['exp']) {
                throw new Exception('Token expired');
            }

            return $payload;
        } catch (Exception $e) {
            return false;
        }
    }

    // 加密數據
    public function encryptData($data)
    {
        // 生成 JWT
        $jwt = $this->generateJWT($data, $this->getKey());
        return $jwt;
    }

    // 解密數據
    public function decryptData($jwt)
    {
        try {
            // 解析 JWT
            $payload = $this->parseJWT($jwt, $this->getKey());
            return $payload;
        } catch (Exception $e) {
            // 解密失敗，返回空數組或其他錯誤處理
            return array();
        }
    }

    // 取得隨機密鑰
    public function getKey()
    {
        return $this->url_key;
    }

    // 加密数据
    public function fixedEncryptData($data)
    {
        // 生成 JWT，传入固定键值对
        $jwt = $this->generateJWT($data, $this->getFixedKey());
        return $jwt;
    }

    // 解密数据
    public function fixedDecryptData($jwt)
    {
        try {
            // 解析 JWT
            $payload = $this->parseJWT($jwt, $this->getFixedKey());
            return $payload;
        } catch (Exception $e) {
            // 解密失敗，返回空數組或其他錯誤處理
            return array();
        }
    }

    // 取得固定密鑰
    public function getFixedKey()
    {
        return $this->fixed_key;
    }
}
