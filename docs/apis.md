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
    "message": "<mensagem referente>",
    "return": null
  }
```