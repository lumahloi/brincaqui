⚠️ **Todos os endpoints exigem este cabeçalho:**

```bash
'content-type': 'application/json'
```

⚠️ **Todas as respostas seguem esta estrutura:**

```bash
'code': 'http status code',
'message': 'mensagem descrevendo o sucesso ou erro',
'return': 'algumas funções possuem retorno'
```

⚠️ **Todas as informações nos corpos das requisições são obrigatórias até que dito o contrário.**

⚠️ **A maioria das requisições exige um cabeçalho de requisição com Cookie PHPSESSID seguindo este formato:**

```bash
'content-type': 'application/json'
'cookie': 'PHPSESSID=?'
```

# Índice

1. Autenticação
  1. [Criação de conta](./auth.md#criação-de-conta)
  2. [Login](./auth.md#login)
  3. [Atualização de informações](./auth.md#atualização-de-informações)
  4. [Deleção de conta](./auth.md#deleção-de-conta)
  5. [Logout](./auth.md#logout)
2. Brinquedo
  1. [Criar](./play.md#criar)
  2. [Listar (cliente)](./play.md#listar-cliente)
  3. [Listar (empresa)](./play.md#listar-empresa)
  4. [Atualizar](./play.md#atualizar)
  5. [Deletar](./play.md#deletar)
3. Avaliação
  1. [Criar](./feedback.md#criar)
  2. [Listar](./feedback.md#listar)
4. Visita
  1. [Criar](./visit.md#criar)
  2. [Listar (cliente)](./visit.md#listar-cliente)
  3. [Listar (empresa)](./visit.md#listar-empresa)
5. Favorito
  1. [Favoritar](./favorite.md#favoritar)
  2. [Listar (cliente)](./favorite.md#listar-cliente)
  3. [Listar (empresa)](./favorite.md#listar-empresa)
  4. [Desfavoritar](./favorite.md#desfavoritar)