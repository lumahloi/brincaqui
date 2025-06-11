⚠️ **Apenas usuários CLIENTE realizam os endpoints desta lista, a não ser quando dito o contrário.**

# Favorito

## Favoritar

**POST** `/api/favorite/<id>`



### Parâmetros da URL

- `id`: ID do brinquedo no qual deseja-se favoritar.


### Respostas

- **201**

  - Brinquedo favoritado com sucesso.

- **400**

  - ID do brinquedo não especificado.

  - Você já favoritou este brinquedo.

  - Ocorreu um erro, tente novamente mais tarde.

---

## Listar

**GET** `/api/favorite/`



### Parâmetros da URL

- `per_page`: quantidade por página, o padrão é 10;

- `page`: página, o padrão é 0.

- `order_by`: opções de ordenação; name, grade, faves, visits, date. O padrão é name.

- `order_dir`: DESC ou ASC. O padrão é ASC.

- `filters`: array separado por vírgula; commodities, discounts e ages.

  

⚠️ `per_page`, `page`, `order_by`, `order_dir` **e** `filters` **são opcionais.**


### Respostas

- **200**

  - Informações extraídas com sucesso.

---
## Desfavoritar

**DELETE** `/api/favorite/<id>`



### Parâmetros da URL

- `id`: ID do brinquedo no qual deseja-se desfavoritar.


### Respostas

- **200**

  - Brinquedo desfavoritado com sucesso.

- **400**

  - ID do brinquedo não especificado.

  - Você não favoritou este brinquedo.

  - Ocorreu um erro, tente novamente mais tarde.