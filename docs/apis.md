# APIs
<!-- terminei na autenticacao -->
⚠️ **Todos os endpoints exigem este cabeçalho:**
```bash
'content-type': 'application/json'
```
⚠️ **Todas as respostas seguem esta estrutura:**
```bash
'code': <http status code>,
'message': <mensagem descrevendo o sucesso ou erro>,
'return': <algumas funções possuem retorno>
```
⚠️ **Todas as informações são obrigatórias até que dito o contrário.**

## Autenticação

### Criação de conta
**POST** `/api/auth/register.php`
#### Corpo
```bash
'fullname' => 'João Maurício',
'email' => 'joaomauricio@gmail.com',
'telephone' => '21979489728',
'password' => '12345678',
'confirmPassword' => '12345678',
'userType' => <type>
```
#### Resposta
- **201**
    - Conta criada com sucesso.
- **400**
    - Não foi possível realizar seu cadastro, revise seus dados e tente novamente.
- **405**
    - Apenas POST, PUT e DELETE permitidos.
---
### Atualização de informações
**PUT** `/api/auth/register.php`
#### Corpo
Todos são opcionais, exceto `confirmPassword` quando `password` existir.
```bash
'email' => 'lumahempresa@gmail.com',
'telephone' => '21979489728',
'password' => 'admin@123',
'confirmPassword' => 'admin@123'
```
#### Cabeçalho
```bash
'content-type': 'application/json'
'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta
- **200**
    - Atualização(s) feita com sucesso.
- **400**
    - Não foi possível realizar sua atualização, revise seus dados e tente novamente.
- **405**
    - Apenas POST, PUT e DELETE permitidos.
    - Tipo de parâmetro inválido.
---
### Deleção de conta
**DELETE** `/api/auth/register.php`
#### Cabeçalho
```bash
'content-type': 'application/json'
'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta
- **200**
    - Conta deletada com sucesso.
- **400**
    - Não foi possível realizar a deleção, revise seus dados e tente novamente.
- **405**
    - Apenas POST, PUT e DELETE permitidos.
    - Tipo de parâmetro inválido.
---
### Login
**POST** `/api/auth/login.php`
#### Corpo
```bash
'email' => 'lumahempresa@gmail.com',
'password' => 'admin@123'
```
#### Resposta
- **200**
    - Login realizado com sucesso.
    ```bash
    "logged_user_id" => <id do usuário>,
    "logged_user_name" => <nome do usuário>,
    "logged_user_type" => <tipo do usuário>,
    "logged_session_id" => <session ID usado para autenticação>
    ```
- **400**
    - Senha inválida.
- **405**
    - Apenas POST permitido.
---
### Logout
**POST** `/api/auth/register.php`
#### Cabeçalho
```bash
'content-type': 'application/json',
'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta
- **200**
    - Até mais!!
- **405**
    - Apenas POST permitido.
---
## Avaliação
### Criar
**POST** `/api/feedback/<id>`
### Usuários
Apenas usuários **clientes** realizam esta ação.
### Parâmetros da URL
- `id`: informação do brinquedo a ser avaliado.
#### Corpo
```bash
    'description' => 'Muito bom voltarei mais vezes',
    'grade_1' => 10,
    'grade_2' => 9.5,
    'grade_3' => 3.5,
    'grade_4' => 2.3,
    'grade_5' => 6.7,
    'grade_6' => 9.1,
    'grade_7' => 3.7,
```
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
### Listar
**GET** `/api/feedback/<id>.php`
### Parâmetros da URL
- `id`: informação do brinquedo cujas avaliações desejam-se listar.
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
## Brinquedo
### Criar
**POST** `/api/play/`
### Usuário
Apenas usuários **empresa** fazem esta ação.
#### Corpo
```bash
    'description' => 'Por conseguinte, o início da atividade geral de formação de atitudes causa impacto indireto na reavaliação dos métodos utilizados na avaliação de resultados. Evidentemente, o comprometimento entre as equipes talvez venha a ressaltar a relatividade da gestão inovadora da qual fazemos parte',
    'cnpj' => '12345678000100',
    'name' => 'Paraíso das Crianças',
    'telephone' => '21978498626',
    'email' => 'contato@paraisodascriancas.com',
    'pictures' => [
      ['picture_name'=>'foto1.jpg'],
      ['picture_name'=>'foto2.jpg']
    ],
    'socials' => [
      ['socials_name'=>'facebook', 'socials_url'=>'https://www.facebook.com/paraisodascriancas'],
      ['socials_name'=>'instagram', 'socials_url'=>'https://www.instagram.com/paraisodascriancas']
    ],
    'prices' => [
      ['prices_title'=>'Passaporte Diário', 'prices_price'=>50],
      ['prices_title'=>'1 hora', 'prices_price'=>20],
    ],
    'times' => [
      ['domingo' => '10:00-22:00'],
      ['segunda' => '10:00-22:00'],
      ['terca' => '10:00-22:00'],
      ['quarta' => '10:00-22:00'],
      ['quinta' => '10:00-22:00'],
      ['sexta' => '10:00-22:00'],
      ['sabado' => '10:00-22:00'],
      ['feriado' => '10:00-22:00']
    ],
    'commodities' => [1,2,6,7],                           // consultar banco de dados
    'discounts' => [4,5],                                 // consultar banco de dados
    'ages' => [5,6,7,8,9,10,11,12,13,14],
    'cep' => '21339825',
    'streetnum' => 'Rua Palmeirense Agostinho 388',
    'city' => 'Rio de Janeiro',
    'neighborhood' => 'Belford Roxo',
    'plus' => 'Casa 2',
    'state' => 'Rio de Janeiro',
    'country' => 'Brasil'
```
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
### Atualizar
**PUT** `/api/play/?params=<param>,<param>`
### Parâmetros da URL
- `params`
  - description, name, telephone, email, pictures, socials, prices, times, commodities, discounts, ages, active, cep, streetnum, city, neighborhood, plus, state, country
#### Corpo
```bash
    'description' => 'Por conseguinte, o início da atividade geral de formação de atitudes causa impacto indireto na reavaliação dos métodos utilizados na avaliação de resultados. Evidentemente, o comprometimento entre as equipes talvez venha a ressaltar a relatividade da gestão inovadora da qual fazemos parte',
    'name' => 'Paraíso das Crianças',
    'telephone' => '21978498626',
    'email' => 'contato@paraisodascriancas.com',
    'pictures' => [
      ['picture_name'=>'foto1.jpg'],
      ['picture_name'=>'foto2.jpg']
    ],
    'socials' => [
      ['socials_name'=>'facebook', 'socials_url'=>'https://www.facebook.com/paraisodascriancas'],
      ['socials_name'=>'instagram', 'socials_url'=>'https://www.instagram.com/paraisodascriancas']
    ],
    'prices' => [
      ['prices_title'=>'Passaporte Diário', 'prices_price'=>50],
      ['prices_title'=>'1 hora', 'prices_price'=>20],
    ],
    'times' => [
      ['domingo' => '10:00-22:00'],
      ['segunda' => '10:00-22:00'],
      ['terca' => '10:00-22:00'],
      ['quarta' => '10:00-22:00'],
      ['quinta' => '10:00-22:00'],
      ['sexta' => '10:00-22:00'],
      ['sabado' => '10:00-22:00'],
      ['feriado' => '10:00-22:00']
    ],
    'commodities' => [1,2,6,7],                           // consultar banco de dados
    'discounts' => [4,5],                                 // consultar banco de dados
    'ages' => [5,6,7,8,9,10,11,12,13,14],
    'cep' => '21339825',
    'streetnum' => 'Rua Palmeirense Agostinho 388',
    'city' => 'Rio de Janeiro',
    'neighborhood' => 'Belford Roxo',
    'plus' => 'Casa 2',
    'state' => 'Rio de Janeiro',
    'country' => 'Brasil'
```
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
### Listar (empresa)
**GET** `/api/play/`
### Parâmetros da URL
- `per_page`;
- `page`;
- `orderBy`: brin_name, brin_grade, brin_faves, brin_visits;
- `orderDir`: DESC, ASC;
- `filters`: commodities, discounts, ages, active, cep, city, neighborhood, state, country.
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
### Deletar brinquedo
**DELETE** `/api/play/<id>`
### Parâmetros da URL
- `id`: informação do brinquedo que se deseja deletar.
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
### Listar (cliente)
**PUT** `/api/play/
### Parâmetros da URL
- `per_page`;
- `page`;
- `orderBy`: brin_name, brin_grade, brin_faves, brin_visits;
- `orderDir`: DESC, ASC;
- `filters`: commodities, discounts, ages, active, cep, city, neighborhood, state, country.
#### Cabeçalho
```bash
  'content-type': 'application/json',
  'cookie': 'PHPSESSID=<cookie>'
```
#### Resposta

---
## Visita
## Favorito