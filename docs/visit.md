⚠️ **Apenas usuários CLIENTE realizam os endpoints desta lista, a não ser quando dito o contrário.**

# Visita

## Criar

**POST** `/api/visit/<id>`



### Parâmetros da URL

- `id`: informação do brinquedo a ser visitado.


### Resposta

- **201**

  - Visita marcada com sucesso.

- **400**

  - Ocorreu um erro, tente novamente mais tarde.

  - ID do brinquedo não especificado.

---

## Listar 

**GET** `/api/visit/`

  





### Parâmetros da URL

- `per_page`: quantidade por página, por padrão 10;

- `page`: página, por padrão 0;

- `order_by`: opções de ordenação; name, grade, faves, visits, date. O padrão é name.

- `order_dir`: DESC ou ASC, por padrão ASC;

- `filters`: array separado por vírgula; commodities, discounts e ages.

⚠️ `per_page`, `page`, `order_by`, `order_dir` **e** `filters` **são opcionais.**


### Resposta

- **200**

  - Informações extraídas com sucesso.

---


