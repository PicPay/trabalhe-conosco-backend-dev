import { Pipe, PipeTransform } from "@angular/core";

/**
 * Pipe para conversão de um número para seu piso.
 *
 * @author L.Gomes
 */
@Pipe({ name: 'floor' })
export class FloorPipe implements PipeTransform {

  /**
   * Converte o valor para o seu piso.
   *
   * @param value valor original
   * @return piso do valor original
   */
  transform(value: number): number {
    return Math.floor(value) || 1;
  }
}
