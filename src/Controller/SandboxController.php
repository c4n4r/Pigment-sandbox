<?php

namespace App\Controller;

use Pigment\Handlers\Harmony\Harmonizer;
use Pigment\Model\Pigment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SandboxController extends AbstractController
{
    #[Route('/', name: 'app_sandbox')]
    public function index(Request $request): Response
    {



        $color = $request->get('color') ?? Pigment::random()->getColorHex();

        $color = new Pigment($color);


        $type = match ($request->get('type')) {
            'split-complementary' => Harmonizer::splitComplementary,
            default => Harmonizer::complementary,
        };


        $harmonized = $color->findColorHarmonized($type);

        $gradient = $color->generateGradient($harmonized, $request->get('gradients-count') ?? 10);

        return $this->render('sandbox/index.html.twig', [
            'type' => $request->get('type', 'complementary'),
            'color' => $color,
            'gradients' => $gradient,
            'harmonized' => $harmonized,
        ]);
    }


}
