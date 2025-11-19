
GET || /api/noticias  // lista (GET) una colección entera de entidades.

GET || /api/noticias/:id   // lista una noticia en especifica.

GET || /api/noticias?orderBy=titulo   // lista una coleccion ordenada por titulo de manera ascendente.

GET || /api/noticias?orderBy=categoria   // lista una coleccion ordenada por categoria de manera ascendente.

GET || /api/noticias?orderBy=titulo&order=descendente //ordena por titulo de manera descendente.

GET || /api/noticias?orderBy=titulo&order=ascendente //ordena por titulo de manera ascendente.

GET || /api/noticias?orderBy=categoria&order=descendente //ordena por categoria de manera descendente.

GET || /api/noticias?orderBy=categoria&order=ascendente //ordena por categoria de manera ascendente.

GET || /api/noticias?filtrarCategoria=id //filtra por id de la categoria.

POST || /api/noticias   // inserta una noticia nueva.

PUT || /api/noticias/:id   // edita una noticia en especifica.

DELETE || /api/noticias/:id   // elimina una noticia.

#validacion por token:
/api/usuarios/token   // usuario: web2admin@gmail.com  contraseña: admin
