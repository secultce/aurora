describe('Painel de Controle - Página de criar Iniciativas', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/oportunidades/adicionar');
    });

    it('Garante que a página de criar oportunidade existe', () => {
        cy.get('h2').contains('Criar oportunidade').should('be.visible');
    });

    it('Garante que os campos para criar uma oportunidade existem', () => {
        cy.get('label:contains("Selecione o tipo da oportunidade")').should('be.visible');
        cy.get('select#opportunityType').should('be.visible');

        cy.get('label:contains("Titulo")').should('be.visible');
        cy.get('input:text#opportunityTitle').should('be.visible');

        cy.get('label:contains("Agente Responsável")').should('be.visible');
        cy.get('select#opportunityCreatedBy').should('be.visible');

        cy.get('label:contains("Áreas de interesse")').should('be.visible');
        cy.get('button[id="add-extraFields[culturalArea]-btn"]').should('be.visible');

        cy.get('label:contains("Imagem de capa")').should('be.visible');
        cy.get('input:file#opportunityCoverImage').should('be.visible');

        cy.get('label:contains("Vincule a oportunidade a uma entidade")').should('be.visible');
        cy.get('label:contains("Iniciativa") > input:radio#entity-initiative').should('be.visible');
        cy.get('label:contains("Evento") > input:radio#entity-event').should('be.visible');
        cy.get('label:contains("Espaço") > input:radio#entity-space').should('be.visible');
        cy.get('label:contains("Agente") > input:radio#entity-agent').should('be.visible');

        cy.get('button:contains("Criar e Publicar")').should('be.visible');
        cy.get('button:contains("Criar em Rascunho")').should('be.visible');
        cy.get('a:contains("Cancelar")').should('be.visible');
    });

    it.only('', () => {
        cy.get()
    });


});
