⚠️ **Apenas usuários EMPRESA realizam os endpoints desta lista, a não ser quando dito o contrário.**

# Brinquedo

## Restrições presentes

- `description`: entre 200 e 2000 caracteres;
- `name`: entre 5 e 45 caracteres;
- `cnpj`: ter 14 caracteres;
- `telephone`: ter 11 caracteres;
- `email`: formato válido, entre 7 e 40 caracteres;
- `pictures`: ser um array do tipo JSON não vazio, ter `picture_name`;
- `socials`: ser um array do tipo JSON não vazio, ter `socials_name` e `socials_url`;
- `prices`: ser um array do tipo JSON não vazio, ter `prices_title` e `prices_price, este último ser úm número;
- `times`: ser um array, ter formato de horário válido;
- `commodities`: ser um array númerico;
- `discounts`: ser um array númerico;
- `ages`: ser um array númerico;
- `cep`: ter 8 caracteres; 
- `streetnum`: ter entre 10 e 60 caracteres;
- `city`:  ter entre 5 e 58 caracteres;
- `neighborhood`: ter entre 5 e 8 caracteres;
- `plus`: ter entre 0 e 40 caracteres;
- `state`: ter entre 4 e 25 caracteres;
- `country`: ter entre 1 e 41 caracteres.

## Criar

**POST** `/api/play/`

### Corpo

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

'commodities' => 'array de ids',                          

'discounts' => 'array de ids',                            

'ages' => 'array de idades',

'cep' => '21339825',

'streetnum' => 'Rua Palmeirense Agostinho 388',

'city' => 'Rio de Janeiro',

'neighborhood' => 'Belford Roxo',

'plus' => 'Casa 2',

'state' => 'Rio de Janeiro',

'country' => 'Brasil'

```

### Resposta

- **200**
  - Brinquedo criado com sucesso.

- **400**
  - Ocorreu um erro, tente novamente mais tarde.

---

## Listar (cliente)

**PUT** `/api/play/`

### Parâmetros da URL

- `per_page`: quantidade por página, por padrão 10;

- `page`: página, por padrão 0;

- `order_by`: name, grade, faves, visits;

- `order_dir`: DESC ou ASC, por padrão ASC;

- `filters`: commodities, discounts, ages, cep, city, neighborhood, state, country.

⚠️ **Todos são opcionais.**
### Resposta

- **200**
  - Array JSON de Brinquedos, retornando os tipos citados em **Criar**.

---

## Listar

**PUT** `/api/play/`

### Parâmetros da URL

- `per_page`: quantidade por página, por padrão 10;

- `page`: página, por padrão 0;

- `order_by`: name, grade, faves, visits;

- `order_dir`: DESC ou ASC, por padrão ASC;

- `filters`: commodities, discounts, ages, active, cep, city, neighborhood, state, country.

⚠️ **Todos são opcionais.**
### Resposta

- **200**
  - Array JSON de Brinquedos, retornando os tipos citados em **Criar**.
---

## Atualizar

**PUT** `/api/play/?params=...

### Parâmetros da URL

Strings separadas por vírgula, pelo menos uma é obrigatória:

  - description, name, telephone, email, pictures, socials, prices, times, commodities, discounts, ages, active*, cep, streetnum, city, neighborhood, plus, state, country.


*active: se o brinquedo está ativo. Por padrão é 1 (ativo), para desativar é 0.

### Corpo

```bash
'atributo' => 'novo valor'
```


### Resposta

- **200**

  - Atualização(s) feita com sucesso.

- **400**

  - Ocorreu um erro, tente novamente mais tarde.

- **405**

  - Tipo de parâmetro inválido.

---


## Deletar

**DELETE** `/api/play/<id>`

### Parâmetros da URL

- `id`: ID do brinquedo no qual se deseja deletar.


### Resposta

- **200**

  - Brinquedo deletado com sucesso.

- **400**

  - ID do brinquedo não especificado.

  - Ocorreu um erro, tente novamente mais tarde.

---
