describe('Página de Lista de Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/iniciativas');
    });

    it('Garante que a página de lista de iniciativas existe', () => {
        cy.get('span.name-one').contains('Início').should('be.visible');
        cy.get('span.name-one').contains('Iniciativa').should('be.visible');
        cy.get('h2.page-title').contains('Iniciativas').should('be.visible');
    });

    it('Garante que o botão "Criar Iniciativa" está visível', () => {
        cy.get('button').contains('Criar Iniciativa').should('be.visible');
    });

    it('Garante que o dropdown de ordenação está visível e funcional', () => {
        cy.get('select').contains('Mais recentes primeiro').should('be.visible');
        cy.get('select').select('Mais antigos primeiro').should('have.value', 'older');
        cy.get('select').select('Mais populares').should('have.value', 'popular');
    });

    it('Garante que a lista de iniciativas está presente e os itens são visíveis', () => {
        cy.get('.initiative-card').should('be.visible');
        cy.get('.initiative-card').first().should('be.visible');
    });

    it('Garante que cada iniciativa tem botão de acessar visível', () => {
        cy.get('.initiative-card').each(($el) => {
            // Verifica se cada card de iniciativa tem o botão "Acessar" visível
            cy.wrap($el).find('a:contains("Acessar"), button:contains("Acessar")').should('be.visible');
        });
    });

    it('Garante que o campo de pesquisa está visível e funcional', () => {
        cy.get('input[placeholder="Pesquisar por Iniciativas"]').should('be.visible');
        cy.get('input[placeholder="Pesquisar por Iniciativas"]').type('Cultura');
        cy.get('input[placeholder="Pesquisar por Iniciativas"]').should('have.value', 'Cultura');
    });
});
