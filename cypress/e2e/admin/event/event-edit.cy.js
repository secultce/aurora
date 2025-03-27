describe('Teste de navegação, validação e edição da página de Eventos', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('henriquelopeslima@example.com', 'Aurora@2024');
        cy.visit('/painel/');
        cy.get(':nth-child(8) > :nth-child(2) > .nav-link').contains('Meus Eventos').click();
        cy.get(':nth-child(1) > :nth-child(5) > .btn-outline-warning').contains('Editar').click();

    });

    it('Garante que a página de editar eventos funciona', () => {
        cy.get(':nth-child(1) > .accordion-header > .accordion-button')
            .contains('Informações de apresentação')
            .should('be.visible');

        cy.get('[for="name"]')
            .contains('Nome do evento')
            .should('be.visible');

        cy.get('.entity-introduction-data > :nth-child(3) > label')
            .contains('Subtítulo do evento')
            .should('be.visible');
        
        cy.get("#add-culturalLanguages-btn")
            .should('be.visible')
            .click();
        
        cy.get("button[data-label='Gastronomia']")
            .should('be.visible')
            .click();
        
        cy.get("#add-tags-btn")
            .should('be.visible')
            .click();

        cy.get("button[data-label='Cultura']")
            .should('be.visible')
            .click();


        cy.get("#event-type")
            .should('be.visible')
            .select('Presencial');
        
        cy.get('[for="short-description"]')
            .contains('Descrição curta')
            .should('be.visible');

        cy.get('[for="long-description"]')
            .contains('Descrição longa')
            .should('be.visible');

        cy.get('.flex-wrap > :nth-child(1) > label')
            .contains('Site (URL)')
            .should('be.visible');

        cy.get('.flex-wrap > :nth-child(2) > label')
            .contains('Descrição do link')
            .should('be.visible');

        cy.get(':nth-child(2) > .accordion-header > .accordion-button')
            .contains('Informações sobre o evento')
            .click();

        cy.get(':nth-child(1) > :nth-child(1) > .form-label')
            .contains('Classificação etária')
            .should('be.visible');

        cy.get(':nth-child(1) > :nth-child(2) > .form-label')
            .contains('Capacidade máxima de pessoas')
            .should('be.visible');

        cy.get(':nth-child(1) > :nth-child(3) > .form-label')
            .contains('Telefone para informações')
            .should('be.visible');

        cy.get('.mt-3 > .col > .form-label')
            .contains('Informações sobre a inscrição')
            .should('be.visible');

        cy.get('.container-fluid > .fw-bold')
            .contains('Acessibilidade')
            .should('be.visible');

        cy.get(':nth-child(5) > .col > .form-label')
            .contains('Libras')
            .should('be.visible');

        cy.get(':nth-child(5) > .col > :nth-child(2) > .form-check-label')
            .contains('Sim')
            .click();

        cy.get(':nth-child(6) > .col > .form-label')
            .contains('Áudio descrição')
            .should('be.visible');

        cy.get(':nth-child(6) > .col > :nth-child(2) > .form-check-label')
            .contains('Sim')
            .click();

        cy.get(':nth-child(3) > .accordion-header > .accordion-button')
            .contains('Data, hora e local do evento')
            .click();

        cy.get('.flex-column > .mb-3')
            .contains('Adicione data, hora e local da ocorrência')
            .should('be.visible');

        cy.get('.justify-content-center > .btn')
            .contains('Adicionar Ocorrência')

        cy.get(':nth-child(4) > .accordion-header > .accordion-button')
            .contains('Redes sociais')
            .click();

        cy.get(':nth-child(2) > :nth-child(1) > .form-label')
            .contains('Instagram')
            .should('be.visible');

        cy.get(':nth-child(2) > :nth-child(2) > .form-label')
            .contains('X')
            .should('be.visible');

        cy.get(':nth-child(2) > :nth-child(3) > .form-label')
            .contains('Facebook')
            .should('be.visible');

        cy.get(':nth-child(3) > :nth-child(1) > .form-label')
            .contains('Vimeo')
            .should('be.visible');

        cy.get(':nth-child(3) > :nth-child(2) > .form-label')
            .contains('YouTube')
            .should('be.visible');

        cy.get(':nth-child(3) > :nth-child(3) > .form-label')
            .contains('LinkedIn')
            .should('be.visible');

        cy.get(':nth-child(4) > :nth-child(1) > .form-label')
            .contains('Spotify')
            .should('be.visible');

        cy.get(':nth-child(4) > :nth-child(2) > .form-label')
            .contains('Pinterest')
            .should('be.visible');

        cy.get(':nth-child(4) > :nth-child(3) > .form-label')
            .contains('TikTok')
            .should('be.visible');

        cy.get("button[form='event-edit-form']")
            .contains('Salvar')
            .should('be.visible')
            .click();

        cy.url().should('include', '/painel/eventos');
        cy.get('.toast')
            .should('be.visible')
            .and('contain', 'O Evento foi atualizado');
    });
});
