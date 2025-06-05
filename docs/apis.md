# APIs

## 1. Cadastro de usuário
### URL
`backend/auth/register.php`
### Cabeçalhos
- `Content-Type`: `application/x-www-form-urlencoded`.
### Corpo (JSON)
```bash
  {
    "fullname": "Maria Silva",
    "email": "maria@email.com",
    "telephone": "11999990000",
    "password": "12345678",
    "confirmPassword": "12345678",
    "userType": 1
  }
```
### Resposta (JSON)
- `200`: usuário criado com sucesso;
- `400`: ocorreu um erro entre as informações fornecidas.
```bash
  {
    "message": "<mensagem referente>"
  }
```

## 2. Login de usuário
### URL
`backend/auth/login.php`
### Cabeçalhos
- `Content-Type`: `application/x-www-form-urlencoded`.
### Corpo (JSON)
```bash
  {
    "email": "maria@email.com",
    "password": "12345678"
  }
```
### Resposta (JSON)
- `200`: login realizado com sucesso;
- `400`: ocorreu um erro entre as informações fornecidas.
```bash
  {
    "message": "<mensagem referente>",
    "return": {
      "logged_user_id": <user_id>,
      "logged_user_name": <user_name>,
      "logged_user_type": <user_type>
    }
  }
```