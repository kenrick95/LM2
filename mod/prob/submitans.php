<h2>Submitting answer</h2>
<b>Li</b>hat <b>ma</b>salah uses <a href="http://ideone.com">ideone.com</a> &copy;
by <a href="http://sphere-research.com">Sphere Research Labs</a>

<form id="submitform" name="submitform" method="POST" action="<?php
   $pid = $data['pid'];
   echo $base_url;
   echo "problem.";
   echo "saveans.";
   echo $pid;
?>">
   <label for='alang'>Choose submission language:</label>
   <select name="alang" id="alang">
   <!--  style="background:#4D90FE; color:white" -->
      <option selected="selected" disabled="disabled" value="0">Choose language</option>
      <option value="7">Ada (gnat-4.3.2)</option>
      <option value="13">Assembler (nasm-2.10.01)</option>
      <option value="45">Assembler (gcc-4.7.2)</option>
      <option value="104">AWK (gawk) (gawk-3.1.6)</option>
      <option value="105">AWK (mawk) (mawk-1.3.3)</option>
      <option value="28">Bash (bash 4.0.35)</option>
      <option value="110">bc (bc-1.06.95)</option>
      <option value="12">Brainf**k (bff-1.0.3.1)</option>
      <option value="11">C (gcc-4.7.2)</option>
      <option value="27">C# (mono-2.8)</option>
      <option value="41">C++ (gcc-4.3.2)</option>
      <option value="1">C++ (gcc-4.7.2)</option>
      <option value="44">C++11 (gcc-4.7.2)</option>
      <option value="34">C99 strict (gcc-4.7.2)</option>
      <option value="14">CLIPS (clips 6.24)</option>
      <option value="111">Clojure (clojure 1.5.0-RC2)</option>
      <option value="118">COBOL (open-cobol-1.0)</option>
      <option value="106">COBOL 85 (tinycobol-0.65.9)</option>
      <option value="32">Common Lisp (clisp) (clisp 2.47)</option>
      <option value="102">D (dmd) (dmd-2.042)</option>
      <option value="36">Erlang (erl-5.7.3)</option>
      <option value="124">F# (fsharp-2.0.0)</option>
      <option value="123">Factor (factor-0.93)</option>
      <option value="125">Falcon (falcon-0.9.6.6)</option>
      <option value="107">Forth (gforth-0.7.0)</option>
      <option value="5">Fortran (gfortran-4.7.2)</option>
      <option value="114">Go (1.0.3)</option>
      <option value="121">Groovy (groovy-2.1.0-rc-1)</option>
      <option value="21">Haskell (ghc-7.4.1)</option>
      <option value="16">Icon (iconc 9.4.3)</option>
      <option value="9">Intercal (c-intercal 28.0-r1)</option>
      <option value="10">Java (sun-jdk-1.7.0_10)</option>
      <option value="55">Java7 (sun-jdk-1.7.0_10)</option>
      <option value="35">JavaScript (rhino) (rhino-1.7R4)</option>
      <option value="112">JavaScript (spidermonkey) (spidermonkey-1.7)</option>
      <option value="26">Lua (luac 5.1.4)</option>
      <option value="30">Nemerle (ncc 0.9.3)</option>
      <option value="25">Nice (nicec 0.9.6)</option>
      <option value="122">Nimrod (nimrod-0.8.8)</option>
      <option value="56">Node.js (0.8.11)</option>
      <option value="43">Objective-C (gcc-4.5.1)</option>
      <option value="8">Ocaml (ocamlopt 3.10.2)</option>
      <option value="119">Oz (mozart-1.4.0)</option>
      <option value="57">PARI/GP (2.5.1)</option>
      <option value="22">Pascal (fpc) (fpc 2.6.2)</option>
      <option value="2">Pascal (gpc) (gpc 20070904)</option>
      <option value="3">Perl (perl 5.16.2)</option>
      <option value="54">Perl 6 (rakudo-2010.08)</option>
      <option value="29">PHP (php 5.4.4)</option>
      <option value="19">Pike (pike 7.6.86)</option>
      <option value="108">Prolog (gnu) (gprolog-1.3.1)</option>
      <option value="15">Prolog (swi) (swipl 5.6.64)</option>
      <option value="4">Python (python 2.7.3)</option>
      <option value="116">Python 3 (python-3.2.3)</option>
      <option value="117">R (R-2.11.1)</option>
      <option value="17">Ruby (ruby-1.9.3)</option>
      <option value="39">Scala (scala-2.10.0)</option>
      <option value="33">Scheme (guile) (guile 1.8.5)</option>
      <option value="23">Smalltalk (gst 3.1)</option>
      <option value="40">SQL (sqlite3-3.7.3)</option>
      <option value="38">Tcl (tclsh 8.5.7)</option>
      <option value="62">Text (text 6.10)</option>
      <option value="115">Unlambda (unlambda-2.0.0)</option>
      <option value="101">Visual Basic .NET (mono-2.4.2.3)</option>
      <option value="6">Whitespace (wspace 0.3)</option>
   </select>
   <br />
   <textarea cols='80' id='asourcecode' name='asourcecode' rows='20' class='codeeditor'></textarea>

   <br />

   <input type='submit' value='Submit' />
   &emsp;
   <input type="button" name="back" value="Back" onClick="window.history.go(-1);"  />
   
</form>