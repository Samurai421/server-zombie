const fs = require('fs');
const path = require('path');

exports.handler = async (event) => {
    if (event.httpMethod === 'POST') {
        const body = JSON.parse(event.body);
        const { password, titulo, descripcion } = body;

        if (password !== 'mateouma1421') {
            return {
                statusCode: 403,
                body: 'Contraseña incorrecta',
            };
        }

        const archivoEventos = path.resolve(__dirname, '../../eventos.json');
        let eventos = [];

        if (fs.existsSync(archivoEventos)) {
            eventos = JSON.parse(fs.readFileSync(archivoEventos, 'utf8'));
        }

        eventos.push({ titulo, descripcion });

        fs.writeFileSync(archivoEventos, JSON.stringify(eventos));

        return {
            statusCode: 200,
            body: 'Evento añadido con éxito',
        };
    }

    return {
        statusCode: 405,
        body: 'Método no permitido',
    };
};
