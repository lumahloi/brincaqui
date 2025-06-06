# APIs

## 1. Cadastro de usuário

### URL

`api/auth/register.php`

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

`api/auth/login.php`

### Cabeçalhos

- `Content-Type`: `application/json`.

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

## 3. Cadastro de brinquedo

### URL

`api/play/register.php`

### Cabeçalhos

- `Content-Type`: `application/json`.
- `Cookie`: valor do ID da sessão.

### Corpo (JSON)

```bash
  {
    "description" : "Por conseguinte, o início da atividade geral de formação de atitudes causa impacto indireto na reavaliação dos métodos utilizados na avaliação de resultados. Evidentemente, o comprometimento entre as equipes talvez venha a ressaltar a relatividade da gestão inovadora da qual fazemos parte",
    "cnpj" : "12345678000100",
    "name" : "Paraíso das Crianças",
    "telephone" : "21978498626",
    "email" : "contato@paraisodascriancas.com",
    "pictures" : {
      {"picture_name":"foto1.jpg"},
      {"picture_name":"foto2.jpg"}
    },
    "socials" : {
      {"socials_name":"facebook", "socials_url":"https://www.facebook.com/paraisodascriancas"},
      {"socials_name":"instagram", "socials_url":"https://www.instagram.com/paraisodascriancas"}
    },
    "prices" : {
      {"prices_title":"Passaporte Diário", "prices_price":50},
      {"prices_title":"1 hora", "prices_price":20},
    },
    "times" : {
      {"domingo" : "10:00-22:00"},
      {"segunda" : "10:00-22:00"},
      {"terca" : "10:00-22:00"},
      {"quarta" : "10:00-22:00"},
      {"quinta" : "10:00-22:00"},
      {"sexta" : "10:00-22:00"},
      {"sabado" : "10:00-22:00"},
      {"feriado" : "10:00-22:00"}
    },
    "commodities" : {1,2,6,7},
    "discounts" : {4,5},
    "ages" : {5,6,7,8,9,10,11,12,13,14}
  }
```

### Resposta (JSON)

- `201`: cadastro realizado com sucesso;
- `400`: ocorreu um erro entre as informações fornecidas.

```bash
  {
    "message": "<mensagem referente>"
  }
  
```
