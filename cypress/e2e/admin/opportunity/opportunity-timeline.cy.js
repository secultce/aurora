describe('Painel de Controle - Página de timeline das Oportunidades', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');
    });

    it('Garante que a página de timeline existe', () => {
        cy.visit('painel/oportunidades/');

        cy.contains('Timeline').click({force: true});

        cy.get('h2').contains('Oportunidade - Chamada para Oficinas de Artesanato - Feira de Cultura Popular - Timeline').should('be.visible');
        cy.get('.d-flex > div > .btn').contains('Voltar').should('be.visible');
        cy.get('tr > :nth-child(1) > a').contains('The resource was created').should('be.visible');
        cy.get('tbody > tr > :nth-child(2)').contains(/\d{2}\/\d{2}\/\d{4}/).should('be.visible');
        cy.get('tbody > tr > :nth-child(3)').contains('unknown').should('be.visible');
        cy.get(':nth-child(5) > .btn').contains('Detalhes').should('be.visible')
    });
});
