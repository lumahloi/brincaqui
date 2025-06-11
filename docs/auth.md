# Autenticação

## Restrições presentes

- `fullname`: entre 5 a 45 caracteres;
- `email`: entre 7 a 40 caracteres, válido e único;
- `telephone`: ter 11 caracteres e ser único;
- `password`: ter entre 8 a 25 caracteres;
- `confirmPassword`: ser idêntico a `password`;
- `userType`: estar contido em [1, 2];

## Criação de conta

**POST** `/api/auth/register.php`

### Corpo

```bash
'fullname' => 'João Maurício',

'email' => 'joaomauricio@gmail.com',

'telephone' => '21979489728',

'password' => '12345678',

'confirmPassword' => '12345678',

'userType' => '1 ou 2'
```

### Resposta

- **201**
      - Conta criada com sucesso.

- **400**
      - Ocorreu um erro, tente novamente mais tarde.

---

## Login

**POST** `/api/auth/login.php`

### Corpo

```bash
'email' => 'joaomauricio@gmail.com',

'password' => '12345678'
```

### Resposta

- **200**
      - Login realizado com sucesso.

```bash
return = [

	"logged_user_id" => // id do usuário,

	"logged_user_name" => // nome do usuário,

	"logged_user_type" => // tipo do usuário,

	"logged_session_id" => // session ID usado para autenticação
  
]
```

- **400**
      - Senha inválida.
      - Ocorreu um erro, por favor tente novamente mais tarde.

---

## Atualização de informações

**PUT** `/api/auth/register.php?params=email,telephone,password`

### Parâmetros da URL

Strings separadas por vírgula: `email`, `telephone`, `password`. Pelo menos uma é obrigatória.

### Corpo

Cada campo é obrigatório quando o parâmetro correspondente existir.

```bash
'email' => 'lumahempresa@gmail.com',

'telephone' => '21979489728',

'password' => 'admin@123',

'confirmPassword' => 'admin@123'
```

### Resposta

- **200**
      - Atualização(s) feita com sucesso.

- **400**
      - Inclua pelo menos um atributo a ser alterado.
      - Ocorreu um erro, tente novamente mais tarde.

- **403**
      - Acesso negado.

* **404**
      - Cookie não encontrado.

- **405**
      - Tipo de parâmetro inválido.

---

## Deleção de conta

**DELETE** `/api/auth/register.php`

### Resposta

- **200**
      - Conta deletada com sucesso.

- **400**
      - Ocorreu um erro, tente novamente mais tarde.

* **404**
      - Cookie não encontrado.

---

## Logout

**POST** `/api/auth/register.php`

### Resposta

- **200**
      - Até mais!!

* **404**
      - Cookie não encontrado.

---
