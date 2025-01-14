describe('Painel de Controle - Página de detalhes de uma Oportunidade', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');
        cy.visit('/painel/oportunidades/378cc989-c2ae-4118-9f19-54bacb8718c4');
    });

    it('Garante que a página de detalhes de uma oportunidade existe e funciona', () => {
        cy.get('h2')
            .contains('Inscrição para o Festival de Danças Folclóricas - Encontro Nordestino')
            .should('be.visible');

        cy.get('.nav-pills > li > a').contains('Dados gerais').should('be.visible');
        cy.get('.nav-pills > li > a').contains('Inscrições').should('be.visible');
        cy.get('.nav-pills > li > a').contains('Fases').should('be.visible');
        cy.get('.nav-pills > li > a').contains('Calendário').should('be.visible');
        cy.get('.nav-pills > li > a').contains('Selos').should('be.visible');

        cy.get('.nav-pills > li > a').contains('Dados gerais').click();

        cy.get('.timeline-custom').should('be.visible');
        cy.get('.timeline-title-custom').contains('Fase de submissão').should('be.visible');
        cy.get('.timeline-title-custom').contains('Fase de documentação').should('be.visible');

        cy.get('.timeline-description-custom').then((elements) => {
            const descriptions = [...elements].map((el) => el.innerText);
        });
    });
});
