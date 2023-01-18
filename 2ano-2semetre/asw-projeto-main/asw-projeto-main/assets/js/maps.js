const today = new Date();

function ageFromDate(birthDate) {
    let age = today.getFullYear() - birthDate.getFullYear();

    const m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    return age;
}

function mapVol(vol) {
    return `<li class='text-body'><strong>Email</strong>: ${vol.email}</li>
            <li class='text-body'><strong>Telefone</strong>: ${vol.telefone}</li>
            <li class='text-body'><strong>Morada</strong>: ${vol.distrito} > ${vol.concelho} > ${vol.freguesia}</li>
            <li class='text-body'><strong>Cartão</strong> Cidadão: ${vol.cartao_cidadao}</li>
            <li class='text-body'><strong>Carta</strong> Condução: ${vol.carta_conducao}</li>
            <li class='text-body'><strong>Género</strong>: ${vol.genero}</li>
            <li class='text-body'><strong>Idade</strong>: ${ageFromDate(new Date(vol.data_nascimento))}</li>`;
}

function mapInstit(instit) {
    return `<li class='text-body'><strong>Tipo</strong>: ${instit.tipo}</li>
            <li class='text-body'><strong>Email</strong>: ${instit.email}</li>
            <li class='text-body'><strong>Telefone</strong>: ${instit.telefone}</li>
            <li class='text-body'><strong>Contacto</strong>: ${instit.contacto} (${instit.telefone_contacto})</li>
            <li class='text-body'><strong>Morada</strong>: ${instit.distrito} > ${instit.concelho} > ${instit.freguesia}, ${instit.morada}</li>
            <li class='text-body'><strong>Descrição</strong>: ${instit.descricao}</li>`;
}

function mapVolArea(vol) {
    return `<li class='text-body'><strong>Email</strong>: ${vol.email}</li>
            <li class='text-body'><strong>Telefone</strong>: ${vol.telefone}</li>
            <li class='text-body'><strong>Género</strong>: ${vol.genero}</li>
            <li class='text-body'><strong>Idade</strong>: ${ageFromDate(new Date(vol.data_nascimento))}</li>`;
}


function mapInstitArea(instit) {
    return `<li><strong>Tipo</strong>: ${instit.tipo}</li>
            <li><strong>Email</strong>: ${instit.email}</li>
            <li><strong>Telefone</strong>: ${instit.telefone}</li>
            <li><strong>Contacto</strong>: ${instit.contacto} (${instit.telefone_contacto})</li>
            <li><strong>Distrito</strong>: ${instit.distrito}</li>
            <li><strong>Concelho</strong>: ${instit.concelho}</li>
            <li><strong>Dia</strong>: ${instit.diasemana}</li>`;
}