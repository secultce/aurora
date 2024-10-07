describe('Página de Lista de Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.visit('/espacos');
    });

    it('Garante que a página de lista de espaços existe', () => {
        cy.get('span.name-one').contains('Início').should('be.visible');
        cy.get('span.name-one').contains('Espaços').should('be.visible');
        cy.get('h2.page-title').contains('Espaços').should('be.visible');
    });

    it('Garante que as opções de visualização estão presentes', () => {
        cy.get('a').contains('Lista').should('be.visible');
        cy.get('a').contains('Mapa').should('be.visible');
    });

    it('Garante que o dropdown de ordenação está visível e funcional', () => {
        cy.get('select').contains('Mais Recente').should('be.visible');
        cy.get('select').select('Mais Antigo').should('have.value', 'old'); // Change from 'oldest' to 'old'
    });

    it('Garante que a lista de espaços está presente e os itens são visíveis', () => {
        cy.get('.spaces-list').should('be.visible');
        cy.get('.spaces-list .space-card').first().should('be.visible');
    });

    it('Garante que cada espaço tem botão de acessar visível', () => {
        cy.get('.spaces-list .space-card').each(($el) => {
            // First, check if there's an <a> tag containing "Acessar"
            cy.wrap($el).find('a:contains("Acessar"), button:contains("Acessar")').should('be.visible');
        });
    });
});