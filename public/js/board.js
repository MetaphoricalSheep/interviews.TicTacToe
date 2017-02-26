function Board() {
    let _lineColor = "#39ADC6",
        _canvas,
        _context,
        _canvasSize,
        _sectionSize,
        _board = ["", "", "", "", "", "", "", "", ""];

    this.SetCanvas = (canvasId, size = 500) => {
        _canvas = document.getElementById(canvasId);
        _context = _canvas.getContext("2d");
        _canvasSize = size;
        _sectionSize = size / 3;
        _CreateBoard();
        return this;
    };

    this.SetLineColor = (color) => {
        _lineColor = color;
        return this;
    };

    let _DrawX = (x, y) => {
        _context.strokeStyle = "#f1be32";
        _context.beginPath();

        let offset = 50;

        _context.moveTo(x + offset, y + offset);
        _context.lineTo(x + _sectionSize - offset, y + _sectionSize - offset);

        _context.moveTo(x + offset, y + _sectionSize - offset);
        _context.lineTo(x + _sectionSize - offset, y + offset);

        _context.stroke();
    };

    let _AddPiece = (pos) => {
        for (let x = 0; x < 3; x++) {
            for (let y = 0; y < 3; y++) {
                let xCoord = x * _sectionSize,
                    yCoord = y * _sectionSize;

                if (pos.x >= xCoord && pos.x <= xCoord + _sectionSize && pos.y >= yCoord
                    && pos.y <= yCoord + _sectionSize) {
                    _DrawX(xCoord, yCoord);
                    return;
                }
            }
        }
    };

    let _GetCanvasMousePosition = (e) => {
        let rect = _canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        }
    };

    let _CreateBoard = () => {
        _canvas.width = _canvasSize;
        _canvas.height = _canvasSize;
        _context.translate(0.5, 0.5);
        _DrawLines(10);

        _canvas.addEventListener('mouseup', (e) => {
            let pos = _GetCanvasMousePosition(e);
            _AddPiece(pos);
            _DrawLines(10);
        })
    };

    let _DrawLines = (width) => {
        let lineStart = 4;
        let lineLength = _canvasSize - 5;
        _context.lineWidth = width;
        _context.lineCap = 'round';
        _context.strokeStyle = _lineColor;
        _context.beginPath();

        for (let y = 1, x = 1; y <= 2; y++, x++) {
            _context.moveTo(lineStart, y * _sectionSize);
            _context.lineTo(lineLength, y * _sectionSize);
            _context.moveTo(x * _sectionSize, lineStart);
            _context.lineTo(x * _sectionSize, lineLength);
        }
        _context.stroke();
    };

    return this;
}
