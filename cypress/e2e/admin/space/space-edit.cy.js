describe('Teste de navegação, validação e edição da página de Espaços', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('alessandrofeitoza@example.com', 'Aurora@2024');
        cy.visit('/painel/espacos');
        cy.contains('Editar').first().click();
        cy.url().should('include', '/editar');
    });

    it('Garante que a página de editar espaços funciona', () => {
        cy.get(':nth-child(1) > .accordion-header > .accordion-button')
            .contains('Informações de apresentação')
            .should('be.visible');

        cy.get('[for="name"]').contains('Nome do espaço').should('be.visible');
        cy.get('[for="short-description"]').contains('Descrição curta').should('be.visible');
        cy.get('[for="long-description"]').contains('Descrição longa').should('be.visible');
        cy.get(':nth-child(9) > :nth-child(1) > label').contains('Site').should('be.visible');
        cy.get(':nth-child(9) > :nth-child(2) > label').contains('Descrição do link').should('be.visible');
        cy.get('.entity-introduction-data > .mt-1 > :nth-child(1) > label')
            .contains('Email público').should('be.visible');
        cy.get('.entity-introduction-data > .mt-1 > :nth-child(2) > label')
            .contains('Telefone Público').should('be.visible');

        cy.get(':nth-child(2) > .accordion-header > .accordion-button')
            .contains('Dados de endereço')
            .should('be.visible')
            .click()
            .should('have.attr', 'aria-expanded', 'true');

        cy.get('.entity-address-data > :nth-child(1) > .col-md-4 > .form-label')
            .contains('CEP').should('be.visible');
        cy.get('.col-md-8 > .form-label').contains('Logradouro').should('be.visible');
        cy.get('.col-md-2 > .form-label').contains('Número').should('be.visible');
        cy.get(':nth-child(2) > .col-md-3 > .form-label').contains('Bairro').should('be.visible');
        cy.get('.col-md-7 > .form-label').contains('Complemento').should('be.visible');
        cy.get('.entity-address-data > :nth-child(3) > :nth-child(1) > .form-label')
            .contains('Estado').should('be.visible');
        cy.get('.entity-address-data > :nth-child(3) > :nth-child(2) > .form-label')
            .contains('Município').should('be.visible');
        cy.get('.col-12 > .form-label').contains('Localização').should('be.visible');

        cy.get(':nth-child(3) > .accordion-header > .accordion-button')
            .contains('Capacidade e Acessibilidade')
            .should('be.visible')
            .click()
            .should('have.attr', 'aria-expanded', 'true');

        cy.get('.entity-accessibility > :nth-child(1) > .col-md-4 > .form-label')
            .contains('Capacidade de pessoas')
            .should('be.visible');

        cy.get(':nth-child(4) > .accordion-header > .accordion-button')
            .contains('Horário de funcionamento')
            .should('be.visible')
            .click()
            .should('have.attr', 'aria-expanded', 'true');

        cy.get('.opening-hours-row .col-md-4 .form-label')
            .should('be.visible')
            .and('contain', 'Dias da semana');

        cy.get('.opening-hours-row .col-md-3:nth-child(2) .form-label')
            .should('be.visible')
            .and('contain', 'Abre às');

        cy.get('.opening-hours-row .col-md-3:nth-child(3) .form-label')
            .should('be.visible')
            .and('contain', 'Fecha às');

        cy.get(':nth-child(5) > .accordion-header > .accordion-button')
            .contains('Permissões')
            .should('be.visible')
            .click()
            .should('have.attr', 'aria-expanded', 'true');

        cy.get('.mb-3 > .form-label').contains('Permitir livre vinculação com').should('be.visible');
        cy.get('.mb-3 > :nth-child(2) > .form-check-label').contains('Pessoas').should('be.visible');
        cy.get(':nth-child(3) > .form-check-label').contains('Organizações').should('be.visible');
        cy.get(':nth-child(4) > .form-check-label').contains('Eventos').should('be.visible');
        cy.get(':nth-child(5) > .form-check-label').contains('Espaços').should('be.visible');

        cy.get(':nth-child(6) > .accordion-header > .accordion-button')
            .contains('Redes sociais')
            .should('be.visible')
            .click()
            .should('have.attr', 'aria-expanded', 'true');

        cy.get('.container-fluid > :nth-child(2) > :nth-child(1) > .form-label')
            .contains('Instagram').should('be.visible');

        cy.get(':nth-child(4) > :nth-child(3) > .form-label')
            .contains('TikTok').should('be.visible');
    });
});
