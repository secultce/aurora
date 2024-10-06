describe('Página de Lista de Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/iniciativas');
    });

    it('Garante que a dashboard de iniciativas está visível', () => {
        cy.get('.entity-dashboard').should('be.visible');
        cy.contains('Iniciativas encontradas');
        cy.contains('em andamento');
    });

    it('Garante que a página de lista de iniciativas existe', () => {
        cy.get('span.name-one').contains('Início').should('be.visible');
        cy.get('span.name-one').contains('Iniciativa').should('be.visible');
        cy.get('h2.page-title').contains('Iniciativa').should('be.visible');
    });

    it('Garante que o botão "Criar uma Iniciativa" está visível', () => {
        cy.get('button').contains('Criar iniciativa').should('be.visible');
    });

    it('Garante que a lista de iniciativas está presente e os itens são visíveis', () => {
        cy.get('.initiative-card').should('be.visible');
        cy.get('.initiative-card').first().should('be.visible');
    });

    it('Garante que cada iniciativa tem botão de acessar visível', () => {
        cy.get('.initiative-card').each(($el) => {
            cy.wrap($el).find('a:contains("Acessar"), button:contains("Acessar")').should('be.visible');
        });
    });
});
