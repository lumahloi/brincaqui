# Avaliação

## Restrições

- `description`: string entre 10 a 200 caracteres, caso seja preenchida;
- `grade_X`: valores float entre 0 a 10.

## Criar (cliente)

**POST** `/api/feedback/<id>`
### Parâmetros da URL

- `id`: ID do brinquedo a ser avaliado.
### Corpo

```bash

'description' => 'Muito bom voltarei mais vezes',

'grade_2' => 9.5,

'grade_3' => 3.5,

'grade_4' => 2.3,

'grade_5' => 6.7,

'grade_6' => 9.1,

'grade_7' => 3.7,

```

⚠️`description` **é opcional.**

### Resposta

- **201**

  - Brinquedo avaliado com sucesso.

- **400**

  - Ocorreu um erro, tente novamente mais tarde.

  - ID do brinquedo não especificado.

---

## Listar

**GET** `/api/feedback/<id>`

### Parâmetros da URL

- `id`: informação do brinquedo cujas avaliações desejam-se listar;

- `per_page`: quantidade por página, o padrão é 10;

- `page`: página, o padrão é 0.

  

⚠️ `per_page` **e** `page` **são opcionais.**


### Resposta

- **200**

  - Informações extraídas com sucesso.

- **400**

  - ID do brinquedo não especificado.

---

