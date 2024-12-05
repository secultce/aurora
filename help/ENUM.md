# Enumerations

Este documento descreve como criar e utilizar as Enums disponíveis no sistema, além de listar todas as Enums atualmente implementadas.

## Como criar?

Para criar uma Enum no sistema, siga o padrão abaixo. Todas as Enums devem:

Declarar o tipo de dado, como `int` ou `string`. Importante utilizar o EnumTrait para ter funcionalidades adicionais ao tipo Enum.

> Ao criar um Enum, é de suma importância usar o EnumTrait. 


Exemplo de Enum
```php
<?php

declare(strict_types=1);

namespace App\Enum;

use App\Enum\Trait\EnumTrait;

enum AuthorizedByTypeEnum: int
{
    use EnumTrait;

    case AGENT = 1;
    case ORGANIZATION = 2;
}

```
> Neste exemplo, o AuthorizedByEnum define dois tipos de autorização possíveis no sistema: AGENT e ORGANIZATION.


## Lista de ENUMS disponíveis
As Enums disponíveis no sistema são:
- AuthorizedByEnum
- EntityEnum
- InscriptionOpportunityStatusEnum

### EntityEnum

#### Descrição
Enumera as entidades principais do sistema.

#### Valores

| Constante      | Valor | Descrição                    |
|----------------|-------|------------------------------|
| `AGENT`        | `1`   | Representa um agente.        |
| `ORGANIZATION` | `2`   | Representa uma organização.  |
| `SPACE`        | `3`   | Representa um espaço.        |
| `EVENT`        | `4`   | Representa um evento.        |
| `INITIATIVE`   | `5`   | Representa uma iniciativa.   |
| `OPPORTUNITY`  | `6`   | Representa uma oportunidade. |

### AuthorizedByEnum

#### Descrição
Define os tipos de entidades autorizadas no sistema.

#### Valores

| Constante      | Valor | Descrição                              |
|----------------|-------|----------------------------------------|
| `AGENT`        | `1`   | Representa um agente autorizado.       |
| `ORGANIZATION` | `2`   | Representa uma organização autorizada. |


### InscriptionOpportunityStatusEnum

#### Descrição
Enumera os possíveis estados de uma inscrição em uma oportunidade.

#### Valores

| Constante   | Valor | Descrição                          |
|-------------|-------|------------------------------------|
| `ACTIVE`    | `1`   | Representa uma inscrição ativa.    |
| `INACTIVE`  | `2`   | Representa uma inscrição inativa.  |
| `SUSPENDED` | `3`   | Representa uma inscrição suspensa. |

## Boas práticas

### Use os valores das Enums diretamente
Evite usar valores literais (como `1`, `2`, etc.) diretamente no código. Sempre utilize as constantes da *Enum* para garantir clareza e manutenibilidade.

**Exemplo:**

```php
// Forma errada
if ($type === 1) { /* lógica */ }

// Forma correta
if ($type === AuthorizedByTypeEnum::AGENT->value) { /* lógica */ }
```

### Valide valores desconhecidos
Certifique-se de tratar casos em que o valor fornecido não corresponde a nenhum dos valores definidos na Enum.

### Centralize as Enums
Todas as Enums devem ser armazenadas no namespace App\Enum e seguir o mesmo padrão de nomenclatura.

### Atualize sempre a documentação
Sempre que um novo valor for adicionado ou modificado, atualize este documento para refletir as mudanças.