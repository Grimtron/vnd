<?php

namespace Drupal\vnd;

class Strings
{
  /**
   * Prüft, ob eine übergebene Zeichenkette mit einer zweiten übergebenen Zeichenkette endet.
   *
   * @param string $haystack Zeichenkette, deren Ende geprüft werden soll.
   * @param string $needle Zeichenkette, die am Ende von $haystack gesucht werden soll
   * @returns true, falls $haystack mit $needle endet, sonst false
   */
  public static function EndsWith($haystack, $needle)
  {
    return substr($haystack, -strlen($needle)) === $needle;
  }

  /**
   * Prüft, ob eine übergebene Zeichenkette mit einer zweiten übergebenen Zeichenkette beginnt.
   *
   * @param string $haystack Zeichenkette, deren Ende geprüft werden soll.
   * @param string $needle Zeichenkette, die am Ende von $haystack gesucht werden soll
   * @returns true, falls $haystack mit $needle endet, sonst false
   */
  public static function StartsWith($haystack, $needle)
  {
    return (substr($haystack, 0, strlen($needle)) === $needle);
  }

  /**
   * Kürzt einen Text auf eine angegebene Zeichenlänge. Ist der Text kürzer als die gewünschte
   * Maximallänge, wird er unverändert zurückgegeben.
   *
   * @param string $text Text, der gekürzt werden soll
   * @param int $maxLength Maximal erlaubte Länge für den Text.
   * @param string $moreTextIndicator Zeichenkette, die an das Ende eines gekürztes Textes gehängt werden soll
   */
  public static function Truncate($text, $maxLength = 255, $moreTextIndicator = '...')
  {
    if (strlen($text) <= $maxLength)
    {
      return $text;
    }

    $text = substr($text, 0, $maxLength - strlen($moreTextIndicator)) . $moreTextIndicator;
    return $text;
  }

  /**
   * Prüft, ob eine Zeichenkette eine Teilzeichenkette enthält.
   *
   * @param string $haystack die zu durchsuchende Zeichenkette
   * @param string $needle die gesuchte Zeichenkette
   * @return bool true, falls die Zeichenkette gefunden wird, sonst false.
   */
  public static function Contains($haystack, $needle)
  {
    return strpos($haystack, $needle) !== false;
  }

  /**
   * Prüft, ob eine Zeichenkette eine Reihe von anderen Zeichenketten enthält.
   *
   * @param string $haystack die zu durchsuchende Zeichenkette
   * @param string[] $needles Liste der gesuchten Zeichenketten
   * @param boolean $caseInsensitive true, falls die Suche unabhängig von Groß-/Kleinschreibung arbeiten soll.
   * @return bool true, falls eine der Zeichenketten enthalten ist, sonst false.
   */
  public static function ContainsAny($haystack, $needles, $caseInsensitive = false)
  {
    if ($needles == null || count($needles) == 0)
    {
      return false;
    }

    if ($caseInsensitive)
    {
      $haystack = strtolower($haystack);
    }

    for ($i = 0; $i < count($needles); $i++)
    {
      $currentNeedle = $caseInsensitive ? strtolower($needles[$i]) : $needles[$i];
      if (self::Contains($haystack, $currentNeedle))
      {
        return true;
      }
    }

    return false;
  }

  /**
   * Prüft, ob eine Zeichenkette mit einer Ziffer anfängt.
   *
   * @param string $text der zu prüfende Text
   * @return bool true, falls die Zeichenkette mit einer Ziffer beginnt, false, falls sie nicht mit einer Ziffer beginnt oder leer/null ist.
   */
  public static function StartsWithDigit($text)
  {
    if ($text == null || strlen($text) == 0)
    {
      return false;
    }

    return is_numeric($text[0]);
  }

  /**
   * Führt eine Massenersetzung von Item-Geboten aus. Geht dabei davon aus, dass zwei gleich große Array mit
   * Such-/Ersetzwerten angegeben werden. WICHTIG: bei zu vielen Ersetzung kann PHP einen Fehler werfen (und somit)
   * das Ergebnis nicht richtig zurückgeben. In diesem Fall in kleineren Ersetzungs-Blöcken abarbeiten.
   *
   * @param string[] $search zu suchende Zeichenketten
   * @param string[] $replace die Ersatz-Zeichenketten
   * @param string $subject der Text, in dem die Ersetzungen durchgeführt werden sollen
   * @param int|null $count falls gesetzt, enthält Count nach Abschluss die Anzahl der durchgeführten Ersetzungen
   *
   * @return 
   */
  public static function stringReplaceBulk($search, $replace, $subject, &$count = null)
  {
    $lookup = array_combine($search, $replace);
    $result = preg_replace_callback(
      '/' .
        implode('|', array_map(
          function ($s)
          {
            return preg_quote($s, '/');
          },
          $search
        )) .
        '/',
      function ($matches) use ($lookup)
      {
        return $lookup[$matches[0]];
      },
      $subject,
      -1,
      $count
    );

    if ($result !== null || count($search) < 2)
    {
      return $result;
    }

    // falls ein Fehler aufgetreten ist, den Standardtext zurückgeben.
    return $subject;
  }
}
