describe('Acessar Fases de uma Oportunidade', () => {
    it('Deve acessar as fases de uma oportunidade', () => {
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');

        cy.contains('Henrique Lopes Lima').click();
        cy.contains('Minhas Oportunidades').click();
        cy.url().should('include', '/admin/opportunities');
        cy.contains('Chamada para Oficinas de Artesanato - Feira de Cultura Popular').click();
        cy.url().should('include', '/admin/opportunities/');
        cy.contains('Fases').click();

        cy.get('#phases').within(() => {
            cy.contains('Fase de submissão').should('be.visible');
            cy.contains('Fase de documentos').should('be.visible');
        });
    });
});
