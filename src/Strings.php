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
    return substr($haystack, -strlen($needle))===$needle;
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
  public static function ContainsAny($haystack, $needles, $caseInsensitive=false)
  {
      if ($needles == null || count($needles) == 0)
      {
          return false;
      }

    if ($caseInsensitive)
    {
        $haystack = strtolower($haystack);
    }

    for ($i=0;$i<count($needles);$i++)
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
}
?>
