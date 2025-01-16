# Decisões Técnicas - Backend

Em alguns momentos durante o desenvolvimento precisamos 
## Upload de Arquivos

Para upload de arquivos estamos usando endpoints especificos, seguindo o padrão abaixo

```
POST /spaces/{id}/images

Content-Type: multipart/form-data
```

(até a tomada dessa decisão) O suporte da PHP para aceitar `multipart/form-data` só é possível via requisições do tipo `POST`.

O fluxo de envio da imagem passa por um único `Service`

```mermaid
flowchart TD
   R((Request)) --POST multipart/form-data--> C[[AgentController]]
   C --UploadedFile--> S([AgentService])
   S --ParameterBag/UploadedFile--> S2([FileService])
   S2 --contents--> ST{{Storage}}
```

## Enums apenas do lado do código
A motivação para não usar o tipo ENUM do proprio banco de dados se deu pois encontramos dificuldades com as migrations, mas, o mais importante:

**Preferimos manter as regras de negócio na camada da aplicação** ao invés de alocar isso no banco de dados.

A documentação dos Enums se encontra [aqui](./ENUM.md)

## Estilo de código
Como o objetivo de melhorar o desempenho e a qualidade do código entregue foi escolhido adotar ferramentas que inspecionam os padrões definidos no código. 

### PHP-CS-Fixer
Foi adotado para garantir a aplicação automática dos padrões de codificação definidos para o projeto. A ferramenta permite corrigir inconsistências de formatação e aplicar melhorias no código de forma eficiente, com base em regras personalizáveis. Isso contribui para um código mais consistente e simplifica as revisões.

### PHP_CodeSniffer
Foi adotado para garantir a conformidade do código com os padrões estabelecidos, promovendo legibilidade e consistência no projeto. A ferramenta automatiza a detecção de violações de estilo e boas práticas, reduzindo o retrabalho e os erros humanos durante revisões de código.