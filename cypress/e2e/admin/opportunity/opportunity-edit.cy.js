describe('Pagina de edição de Oportunidade', () => {
    beforeEach(() => {
        cy.viewport(1920, 1080);
        cy.login('talysonsoares@example.com', 'Aurora@2024');
        cy.visit('/painel/oportunidades/');
        cy.get('tr:contains("Titulo da oportunidade para o teste")').contains('Editar').click();

        Cypress.on('uncaught:exception', (err) => {
            if (err.message.includes('i.createPopper is not a function')) {
                return false;
            }
        });
    });

    it('Garante que a página de edição existe', () => {
        cy.url().should('to.match', /\/painel\/oportunidades\/(....................................)\/editar$/gm);

        cy.contains('Titulo da oportunidade para o teste').should('exist');
    });

    describe('Garante aba "Informações gerais"', () => {
        it('Garante que a aba existe', () => {
            cy.get('#pills-general_info-tab:contains(Informações gerais)')
                .should('exist')
                .click();
        });

        it('Garante que os campos de "Informações gerais" existem', () => {
            cy.contains('Modalidade e Objeto do Fomento').should('be.visible');

            cy.contains('Modalidade de Fomento').click();
            cy.focused().should('have.attr', 'name', 'promotionModality');

            cy.contains('Objeto de Fomento').click();
            cy.focused().should('have.attr', 'name', 'promotionObject');

            cy.contains('Data de início').should('be.visible');

            cy.contains('Data e hora').click();
            cy.focused().should('have.attr', 'name', 'period[startDate]');

            cy.contains('Quem poderá participar').should('be.visible');

            cy.contains('Previsão de propostas selecionadas').click();
            cy.focused().should('have.attr', 'name', 'selectedLimit');

            cy.contains('Limite de inscrições por agente').click();
            cy.focused().should('have.attr', 'name', 'inscriptionsPerAgentLimit');

            cy.contains('Propostas selecionadas por agente').click();
            cy.focused().should('have.attr', 'name', 'selectedPerAgentLimit');

            cy.contains('Valor do Edital').should('be.visible');

            cy.get('[name=grantAmount]').should('be.visible');
        });
    });

    describe('Garante aba "Informações públicas"', () => {
        it('Garante que a aba existe', () => {
            cy.get('#pills-public_info-tab:contains(Informações públicas)')
                .should('be.visible')
                .click();
        });

        it.only('Garante que os campos de "Informações públicas" existem', () => {
            const [ profilePath, coverPath ] = [ 'profile-image.jpg', 'cover-image.jpg' ];

            cy.get('#pills-public_info-tab:contains(Informações públicas)')
                .should('be.visible')
                .click();
            cy.contains('Informações de apresentação').should('be.visible');

            cy.contains('Adicionar imagem de capa')
                .should('be.visible')
                .click();
            cy.get('#coverImage')
                .should('exist')
                .attachFile(coverPath)
                .then($input => {
                    expect($input[0].files[0].name).to.equal('cover-image.jpg');
                });
            cy.get('#cover-image > img.image-preview').should('exist')
                .and($img => {
                    expect($img[0].naturalWidth).to.be.greaterThan(0);
                });

            cy.get('#profile-image')
                .should('be.visible')
                .click();
            cy.get('#image')
                .should('exist')
                .attachFile(profilePath)
                .then($input => {
                    expect($input[0].files[0].name).to.equal('profile-image.jpg');
                });
            cy.get('#profile-image > img.image-preview').should('exist')
                .and($img => {
                    expect($img[0].naturalWidth).to.be.greaterThan(0);
                });

            cy.contains('Nome da oportunidade').click();
            cy.focused().should('have.attr', 'name', 'name');

            cy.contains('Tipo da oportunidade').click();
            cy.focused().should('have.attr', 'name', 'extraFields[type]');

            cy.contains('Descrição curta').click();
            cy.focused().should('have.attr', 'name', 'extraFields[shortDescription]');

            cy.contains('Descrição longa').click();
            cy.focused().should('have.attr', 'name', 'extraFields[longDescription]');

            cy.contains('Áreas de Atuação').click();
            cy.focused().should('have.id','add-areasOfActivity-btn');
            cy.get('[aria-labelledby=add-areasOfActivity-btn]')
                .should('be.visible')
                .contains('Outros')
                .click();
            cy.get('#tags-container-areasOfActivity')
                .should('contain', 'Outros');

            cy.contains('Anexos e links').should('be.visible');

            cy.contains('Descrição do link').click();
            cy.focused().should('have.attr', 'name', 'linkName[]');

            cy.contains('Links').contains('Link (URL)').click();
            cy.focused().should('have.attr', 'name', 'linkUrl[]');

            cy.contains('Descrição do vídeo').click();
            cy.focused().should('have.attr', 'name', 'videoName[]');

            cy.contains('Vídeos').contains('Link (URL)').click();
            cy.focused().should('have.attr', 'name', 'videoUrl[]');
        });
    });
});
